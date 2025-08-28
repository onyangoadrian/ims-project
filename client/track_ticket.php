<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'client') {
    header("Location: ../login.php");
    exit();
}
$title = "Track Ticket";

$ticket = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $stmt = $conn->prepare("SELECT * FROM service_requests WHERE id=? AND client_username=? LIMIT 1");
    $stmt->bind_param("is", $ticket_id, $_SESSION['username']);
    $stmt->execute();
    $ticket = $stmt->get_result()->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../assets/style.css">
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
      <li><a href="track_ticket.php" class="active">Track Ticket</a></li>
    </ul>
  </aside>

  <main>
    <h2><?= $title ?></h2>
    <p class="subtitle">Enter your ticket number to check the status.</p>

    <form method="POST" class="card">
      <input type="number" name="ticket_id" placeholder="Ticket Number" required>
      <button type="submit" class="btn-primary">Track</button>
    </form>

    <?php if ($ticket): ?>
      <div class="card">
        <p><strong>Ticket #<?= $ticket['id'] ?></strong></p>
        <p>Description: <?= htmlspecialchars($ticket['description']) ?></p>
        <p>Status: <?= ucfirst($ticket['status']) ?></p>
        <p>Created: <?= $ticket['created_at'] ?></p>
      </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
      <div class="card">No ticket found with that number.</div>
    <?php endif; ?>
    <aside>
  <ul>
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="submit_request.php">Submit Request</a></li>
    <li><a href="track_ticket.php">Track Ticket</a></li>
    <li><a href="schedule.php">Scheduled Work</a></li>
    <li><a href="invoices.php">Invoices</a></li>
    <li><a href="profile.php">My Profile</a></li>
  </ul>
</aside>
  </main>
</body>
</html>
