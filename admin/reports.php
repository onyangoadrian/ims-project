<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
$title = "Reports";

// : fetch recent service requests 
$reports = [];
if ($result = $conn->query("SHOW TABLES LIKE 'service_requests'")) {
    if ($result->num_rows > 0) {
        $reports = $conn->query("SELECT id, description, status, created_at FROM service_requests ORDER BY created_at DESC LIMIT 10");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    /* stylesstyle ya reports */
    .ticket {
      border: 1px solid #ccc;
      padding: 15px;
      margin-bottom: 10px;
      border-radius: 8px;
      background: #f9f9f9;
      box-shadow: 1px 1px 5px rgba(0,0,0,0.1);
    }
    .ticket h4 {
      margin: 0 0 5px 0;
    }
    .ticket p {
      margin: 3px 0;
    }
    .ticket .status {
      font-weight: bold;
    }
  </style>
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
      <li><a href="technicians.php">Technicians</a></li>
      <li><a href="reports.php" class="active">Reports</a></li>
    </ul>
  </aside>

  <main>
    <h2>Reports</h2>
    <p class="subtitle">Generated system reports.</p>

    <!-- Ticket Display -->
    <div class="reports">
      <?php if (!empty($reports) && $reports->num_rows > 0): ?>
        <?php while($row = $reports->fetch_assoc()): ?>
          <div class="ticket">
            <h4>Ticket #<?= $row['id'] ?></h4>
            <p><strong>Description:</strong> <?= htmlspecialchars($row['description']) ?></p>
            <p><strong>Status:</strong> <span class="status"><?= ucfirst($row['status']) ?></span></p>
            <p><strong>Created:</strong> <?= $row['created_at'] ?></p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No records found.</p>
      <?php endif; ?>
    </div>

  </main>
</body>
</html>
