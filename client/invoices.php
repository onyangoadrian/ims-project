<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
  header("Location: ../login.php");
  exit();
}
$title = "My Invoices";
$username = $_SESSION['username'];

$sql = "SELECT i.*, sr.ticket_number, sr.description, sr.scheduled_date, sr.status,
               t.name AS tech_name
         FROM invoices i
         JOIN service_requests sr ON i.request_id = sr.id
         LEFT JOIN technicians t ON sr.technician_id = t.id
         WHERE i.client_username = ?
         ORDER BY i.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$invoices = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    /*  dashboard style */
    .invoice-card {
      background: var(--card-bg, #f5f7fa);  /* light tone like dashboard cards */
      padding:14px;
      border-radius:10px;
      box-shadow:0 2px 8px rgba(0,0,0,0.06);
      margin-bottom:12px;
    }
    .totals { font-weight:700; color:#222; }
  </style>
</head>
<body class="client-theme">
<header>
  <h1>Client Portal</h1>
  <a href="../logout.php" class="logout">Logout</a>
</header>

<aside>
  <ul>
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="submit_request.php">Submit Request</a></li>
    <li><a href="track_ticket.php">Track Ticket</a></li>
    <li><a href="schedule.php">Scheduled Work</a></li>
    <li><a href="invoices.php" class="active">Invoices</a></li>
    <li><a href="profile.php">My Profile</a></li>
  </ul>
</aside>

<main>
  <h2>My Invoices</h2>

  <?php if ($invoices->num_rows === 0): ?>
    <div class="card">No invoices yet. Invoices appear once a job is completed.</div>
  <?php endif; ?>

  <?php while($inv = $invoices->fetch_assoc()): ?>
    <div class="invoice-card">
      <div><strong>Invoice #<?= $inv['id'] ?></strong> • Ticket #<?= htmlspecialchars($inv['ticket_number']) ?></div>
      <div><em><?= htmlspecialchars($inv['description']) ?></em></div>
      <div>Technician: <?= htmlspecialchars($inv['tech_name'] ?: '—') ?></div>
      <div>Date: <?= substr($inv['created_at'], 0, 16) ?></div>
      <hr>
      <div>Parts: <?= number_format($inv['parts_total'], 2) ?></div>
      <div>Labor: <?= number_format($inv['labor_total'], 2) ?></div>
      <div>Tax: <?= number_format($inv['tax'], 2) ?></div>
      <div class="totals">Total: <?= number_format($inv['total'], 2) ?></div>
    </div>
  <?php endwhile; ?>

</main>
</body>
</html>
