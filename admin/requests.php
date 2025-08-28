<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
$title = "Service Requests";
$message = "";

/* ================================
   Handle admin-created request
================================ */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $client = $_POST['client_username'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $scheduled_date = $_POST['scheduled_date'];

    $stmt = $conn->prepare("INSERT INTO service_requests (client_username, description, priority, scheduled_date, status) 
                            VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssss", $client, $description, $priority, $scheduled_date);

    if ($stmt->execute()) {
        $message = "✅ Maintenance request created successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}

/* ================================
   Fetch all requests & clients
================================ */
$requests = $conn->query("SELECT * FROM service_requests ORDER BY id DESC");

// Fetch clients for dropdown
$clients = $conn->query("SELECT username, full_name FROM clients ORDER BY full_name ASC");
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
      <li><a href="requests.php" class="active">Service Requests</a></li>
      <li><a href="workorders.php">Work Orders</a></li>
      <li><a href="technicians.php">Technicians</a></li>
      <li><a href="reports.php">Reports</a></li>
    </ul>
  </aside>

  <main>
    <h2>Service Requests</h2>

    <?php if ($message): ?>
      <div class="card"><?= $message ?></div>
    <?php endif; ?>

    <h3>Create Maintenance Request</h3>
    <form method="POST" class="styled-form">
      <label>Client / Department:</label>
      <select name="client_username" required>
        <option value="">-- Select Client / Department --</option>
        <?php while ($c = $clients->fetch_assoc()): ?>
          <option value="<?= htmlspecialchars($c['username']) ?>">
            <?= htmlspecialchars($c['full_name'] ?: $c['username']) ?>
          </option>
        <?php endwhile; ?>
      </select>

      <label>Description:</label>
      <textarea name="description" required></textarea>

      <label>Priority:</label>
      <select name="priority" required>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
      </select>

      <label>Scheduled Date:</label>
      <input type="datetime-local" name="scheduled_date" required>

      <button type="submit" name="create" class="btn-primary">Create Request</button>
    </form>

    <h3>All Requests</h3>
    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Client</th>
          <th>Description</th>
          <th>Priority</th>
          <th>Status</th>
          <th>Scheduled Date</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $requests->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['client_username']) ?></td>
            <td><?= htmlspecialchars($row['description']) ?></td>
            <td><?= ucfirst($row['priority']) ?></td>
            <td><?= ucfirst($row['status']) ?></td>
            <td><?= $row['scheduled_date'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
