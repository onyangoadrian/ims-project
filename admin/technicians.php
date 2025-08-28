<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
$title = "Technicians";
$message = "";

// Handle add technician
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO technicians (name, phone, status) VALUES (?, ?, 'available')");
    $stmt->bind_param("ss", $name, $phone);
    if ($stmt->execute()) {
        $message = "✅ Technician added successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}

// Get all technicians
$techs = $conn->query("SELECT * FROM technicians");
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
      <li><a href="workorders.php">Work Orders</a></li>
      <li><a href="technicians.php" class="active">Technicians</a></li>
      <li><a href="reports.php">Reports</a></li>
    </ul>
  </aside>

  <main>
    <h2>Technicians</h2>

    <?php if ($message): ?>
      <div class="card"><?= $message ?></div>
    <?php endif; ?>

    <h3>Add Technician</h3>
    <form method="POST" class="styled-form">
      <label>Name:</label>
      <input type="text" name="name" required>
      
      <label>Phone:</label>
      <input type="text" name="phone" required>

      <button type="submit" name="add" class="btn-primary">Add Technician</button>
    </form>

    <h3>Technician List</h3>
    <table class="styled-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $techs->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
              <?php if($row['status'] == "busy"): ?>
                <span style="color:red; font-weight:bold;">Busy</span>
              <?php else: ?>
                <span style="color:green; font-weight:bold;">Available</span>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </main>
</body>
</html>
