<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
$title = "Dashboard";

/* ======================
   Fetch Data for Charts
   ====================== */
// Work orders status
$pending = $conn->query("SELECT COUNT(*) AS total FROM service_requests WHERE status='pending'")->fetch_assoc()['total'] ?? 0;
$inProgress = $conn->query("SELECT COUNT(*) AS total FROM service_requests WHERE status='in_progress'")->fetch_assoc()['total'] ?? 0;
$completed = $conn->query("SELECT COUNT(*) AS total FROM service_requests WHERE status='completed'")->fetch_assoc()['total'] ?? 0;

// Technician availability
$busyTechs = $conn->query("SELECT COUNT(*) AS total FROM technicians WHERE status='busy'")->fetch_assoc()['total'] ?? 0;
$availableTechs = $conn->query("SELECT COUNT(*) AS total FROM technicians WHERE status='available'")->fetch_assoc()['total'] ?? 0;

// Requests by priority
$lowPriority = $conn->query("SELECT COUNT(*) AS total FROM service_requests WHERE priority='low'")->fetch_assoc()['total'] ?? 0;
$mediumPriority = $conn->query("SELECT COUNT(*) AS total FROM service_requests WHERE priority='medium'")->fetch_assoc()['total'] ?? 0;
$highPriority = $conn->query("SELECT COUNT(*) AS total FROM service_requests WHERE priority='high'")->fetch_assoc()['total'] ?? 0;

// Low stock inventory count
$lowStock = $conn->query("SELECT COUNT(*) AS total FROM inventory WHERE quantity < 10")->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../assets/style.css">
  <!-- Font Awesome for Admin Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .chart-container {
      width: 30%;
      max-width: 280px;
      display: inline-block;
      margin: 15px;
      vertical-align: top;
    }
    .stats-card {
      background: #f9f9f9ff;
      border-radius: 10px;
      padding: 15px;
      margin: 10px 0;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .welcome {
      font-size: 1.2em;
      margin-bottom: 20px;
    }
    .welcome i {
      color: #2c3e50;
      margin-right: 8px;
    }
    .charts-row {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
    }
    .chart-title {
      text-align: center;
      font-weight: bold;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Admin Dashboard</h1>
    <a href="../logout.php" class="logout">Logout</a>
  </header>

  <aside>
    <ul>
      <li><a href="dashboard.php" class="active">Dashboard</a></li>
      <li><a href="inventory.php">Inventory</a></li>
      <li><a href="requests.php">Service Requests</a></li>
      <li><a href="workorders.php">Work Orders</a></li>
      <li><a href="technicians.php">Technicians</a></li>
      <li><a href="reports.php">Reports</a></li>
    </ul>
  </aside>

  <main>
    <div class="welcome">
      <i class="fa-solid fa-user-shield"></i> Welcome, <?= $_SESSION['username'] ?>
    </div>

    <div class="stats-card">
      <h3>Low Stock Items: <?= $lowStock ?></h3>
    </div>

    <div class="charts-row">
      <div class="chart-container">
        <div class="chart-title">Work Orders Status</div>
        <canvas id="workOrdersChart" width="250" height="250"></canvas>
      </div>
      <div class="chart-container">
        <div class="chart-title">Technician Availability</div>
        <canvas id="techChart" width="250" height="250"></canvas>
      </div>
      <div class="chart-container">
        <div class="chart-title">Service Requests by Priority</div>
        <canvas id="priorityChart" width="250" height="250"></canvas>
      </div>
    </div>
  </main>

  <script>
    // Work Orders Chart
    new Chart(document.getElementById('workOrdersChart'), {
      type: 'pie',
      data: {
        labels: ['Pending', 'In Progress', 'Completed'],
        datasets: [{
          data: [<?= $pending ?>, <?= $inProgress ?>, <?= $completed ?>],
          backgroundColor: ['#f39c12', '#3498db', '#2ecc71']
        }]
      }
    });

    // Technicians Chart
    new Chart(document.getElementById('techChart'), {
      type: 'doughnut',
      data: {
        labels: ['Busy', 'Available'],
        datasets: [{
          data: [<?= $busyTechs ?>, <?= $availableTechs ?>],
          backgroundColor: ['#e74c3c', '#2ecc71']
        }]
      }
    });

    // Priority Chart
    new Chart(document.getElementById('priorityChart'), {
      type: 'bar',
      data: {
        labels: ['Low', 'Medium', 'High'],
        datasets: [{
          label: 'Requests',
          data: [<?= $lowPriority ?>, <?= $mediumPriority ?>, <?= $highPriority ?>],
          backgroundColor: ['#2ecc71', '#f39c12', '#e74c3c']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  </script>
</body>
</html>
