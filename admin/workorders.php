<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
$title = "Work Orders";
$message = "";

/* ========== Handle Technician Assignment ========== */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign'])) {
    $request_id = intval($_POST['request_id']);
    $technician_id = intval($_POST['technician_id']);
    $scheduled_date = $_POST['scheduled_date'];
    $spare = isset($_POST['spare']) ? intval($_POST['spare']) : null;

    $stmt = $conn->prepare("UPDATE service_requests SET technician_id=?, scheduled_date=?, status='in_progress' WHERE id=?");
    $stmt->bind_param("isi", $technician_id, $scheduled_date, $request_id);

    if ($stmt->execute()) {
        $conn->query("UPDATE technicians SET status='busy' WHERE id=$technician_id");

        // Handle optional spare part, using 'work_orders' table
        if (!empty($spare)) {
            $conn->query("INSERT INTO work_orders (request_id, part_id) VALUES ($request_id, $spare)");
            $conn->query("UPDATE inventory SET quantity = quantity - 1 WHERE id=$spare AND quantity > 0");
        }

        $message = "✅ Technician assigned successfully!";
    } else {
        $message = "❌ Error assigning technician: " . $conn->error;
    }
}

/* ========== Handle Completion of Work Order ========== */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['complete'])) {
    $request_id = intval($_POST['request_id']);
    $technician_id = intval($_POST['technician_id']);

    // Mark request as completed
    $conn->query("UPDATE service_requests SET status='completed' WHERE id=$request_id");

    // Free technician
    $conn->query("UPDATE technicians SET status='available' WHERE id=$technician_id");

    // === Generate detailed invoice ===
    $labor_cost = 500.00;
    $parts_cost = 0;

    // Get the price of the spare part from the 'inventory' table
    $part_query = $conn->query("SELECT i.price FROM work_orders wo JOIN inventory i ON wo.part_id = i.id WHERE wo.request_id=$request_id");
    if ($part = $part_query->fetch_assoc()) {
        $parts_cost = $part['price'];
    }

    $subtotal = $labor_cost + $parts_cost;
    $tax = $subtotal * 0.16;
    $total = $subtotal + $tax;

    $stmt = $conn->prepare("INSERT INTO invoices (request_id, client_username, parts_total, labor_total, tax, total, created_at) SELECT id, client_username, ?, ?, ?, ?, NOW() FROM service_requests WHERE id=?");
    $stmt->bind_param("ddddi", $parts_cost, $labor_cost, $tax, $total, $request_id);
    $stmt->execute();
    $invoice_id = $stmt->insert_id;

    $conn->query("UPDATE service_requests SET invoice_id=$invoice_id WHERE id=$request_id");

    $message = "✅ Work order marked completed and invoice generated!";
}

/* ========== Fetch Data ========== */
// Pending requests (not assigned yet)
$pendingRequests = $conn->query("SELECT * FROM service_requests WHERE status='pending'");

// Active work orders (in progress)
$activeOrders = $conn->query("SELECT r.*, t.name AS technician_name, t.status AS technician_status FROM service_requests r JOIN technicians t ON r.technician_id = t.id WHERE r.status='in_progress'");

// Available technicians
$technicians = $conn->query("SELECT * FROM technicians WHERE status='available'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <header>
    <h1>Admin Panel</h1>
    <a href="../logout.php" class="logout">Logout</a>
  </header>

  <aside>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="inventory.php">Inventory</a></li>
      <li><a href="requests.php">Service Requests</a></li>
      <li><a href="workorders.php" class="active">Work Orders</a></li>
      <li><a href="technicians.php">Technicians</a></li>
      <li><a href="reports.php">Reports</a></li>
    </ul>
  </aside>

  <main>
    <h2><?= $title ?></h2>

    <?php if ($message): ?>
      <div class="card"><?= $message ?></div>
    <?php endif; ?>

    <h3>Pending Requests</h3>
    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Client</th>
          <th>Description</th>
          <th>Priority</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $pendingRequests->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['client_username']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= ucfirst($row['priority']) ?></td>
            <td>
              <form method="POST" style="display:inline-block;">
                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                <select name="technician_id" required>
                  <option value="">Assign Technician</option>
                  <?php 
                  $techList = $conn->query("SELECT * FROM technicians WHERE status='available'");
                  while($tech = $techList->fetch_assoc()): ?>
                    <option value="<?= $tech['id'] ?>"><?= $tech['name'] ?> (<?= $tech['phone'] ?>)</option>
                  <?php endwhile; ?>
                </select>
                <input type="datetime-local" name="scheduled_date" required>

                <select name="spare">
                  <option value="">-- No Spare Part --</option>
                  <?php 
                  $spares = $conn->query("SELECT * FROM inventory ORDER BY id ASC");
                  while($sp = $spares->fetch_assoc()): ?>
                    <option value="<?= $sp['id'] ?>"><?= $sp['name'] ?> (Stock: <?= $sp['quantity'] ?>)</option>
                  <?php endwhile; ?>
                </select>

                <button type="submit" name="assign" class="btn-primary">Assign</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <h3>Active Work Orders</h3>
    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Client</th>
          <th>Description</th>
          <th>Technician</th>
          <th>Scheduled Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $activeOrders->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['client_username']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= htmlspecialchars($row['technician_name']) ?> (<?= ucfirst($row['technician_status']) ?>)</td>
            <td><?= $row['scheduled_date'] ?></td>
            <td>
              <form method="POST">
                <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                <input type="hidden" name="technician_id" value="<?= $row['technician_id'] ?>">
                <button type="submit" name="complete" class="btn-success">Mark Complete</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
