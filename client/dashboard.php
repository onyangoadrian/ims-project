<?php
include "../config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'client') {
    header("Location: ../login.php");
    exit();
}

$title = "Client Dashboard";
$client_username = $_SESSION['username'];

/* ==============================
   Fetch Client Profile Info
   ============================== */
$stmt = $conn->prepare("SELECT full_name, email, phone, address FROM clients WHERE username=?");
$stmt->bind_param("s", $client_username);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc();

/* ==============================
   Active (pending or in_progress)
   ============================== */
$stmt = $conn->prepare("
    SELECT COUNT(*) AS total 
    FROM service_requests 
    WHERE client_username=? 
    AND status IN ('pending','in_progress')
");
$stmt->bind_param("s", $client_username);
$stmt->execute();
$activeTickets = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

/* ==============================
   Completed Requests
   ============================== */
$stmt = $conn->prepare("
    SELECT COUNT(*) AS total 
    FROM service_requests 
    WHERE client_username=? 
    AND status='completed'
");
$stmt->bind_param("s", $client_username);
$stmt->execute();
$completedTickets = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

/* ==============================
   Scheduled Maintenance (pending only)
   ============================== */
$sql = "
    (SELECT sr.id AS ticket_id
     FROM service_requests sr
     LEFT JOIN work_orders wo ON sr.id = wo.request_id
     WHERE sr.client_username = ? 
       AND sr.status = 'pending' 
       AND wo.request_id IS NULL)

    UNION ALL

    (SELECT sr.id AS ticket_id
     FROM work_orders wo
     JOIN service_requests sr ON wo.request_id = sr.id
     WHERE sr.client_username = ? 
       AND wo.status = 'pending')
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $client_username, $client_username);
$stmt->execute();
$upcoming = $stmt->get_result()->num_rows;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    .profile-summary { 
      background:#fff; 
      padding:16px; 
      border-radius:10px; 
      margin-bottom:20px; 
      box-shadow:0 2px 8px rgba(0,0,0,0.08);
    }
    .profile-summary h3 { margin-top:0; }
    .profile-summary p { margin:6px 0; }
  </style>
</head>
<body class="client-theme">
  <header>
    <h1>Client Portal</h1>
    <a href="../logout.php" class="logout">Logout</a>
  </header>

  <aside>
    <ul>
      <li><a href="dashboard.php" class="active">Dashboard</a></li>
      <li><a href="submit_request.php">Submit Request</a></li>
      <li><a href="track_ticket.php">Track Ticket</a></li>
      <li><a href="schedule.php">Scheduled Maintenance</a></li>
      <li><a href="invoices.php">Invoices</a></li>
      <li><a href="profile.php">My Profile</a></li>
    </ul>
  </aside>

  <main>
    <h2>Welcome, <?= htmlspecialchars($client_username) ?></h2>
    <p class="subtitle">Here you can track your service requests and view your account details.</p>

    <!-- Profile Info Card -->
    <div class="profile-summary">
      <h3>My Profile</h3>
      <p><strong>Full Name:</strong> <?= htmlspecialchars($profile['full_name'] ?? 'Not set') ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($profile['email'] ?? 'Not set') ?></p>
      <p><strong>Phone:</strong> <?= htmlspecialchars($profile['phone'] ?? 'Not set') ?></p>
      <p><strong>Address:</strong> <?= htmlspecialchars($profile['address'] ?? 'Not set') ?></p>
    </div>

    <!-- Tickets Summary -->
    <div class="card client-card">My Active Tickets: <?= $activeTickets ?></div>
    <div class="card client-card">Scheduled Maintenance: <?= $upcoming ?></div>
    <div class="card client-card">Completed Requests: <?= $completedTickets ?></div>
  </main>
</body>
</html>
