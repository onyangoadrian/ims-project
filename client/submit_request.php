<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'client') {
    header("Location: ../login.php");
    exit();
}
$title = "Submit Request";

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $client_username = $_SESSION['username'];

    // Insert request into DB
    $stmt = $conn->prepare("INSERT INTO service_requests (client_username, description, priority) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $client_username, $description, $priority);

    if ($stmt->execute()) {
        $ticket_id = $stmt->insert_id;
        $message = "✅ Request submitted successfully. Your ticket number is <strong>#{$ticket_id}</strong>.";
    } else {
        $message = "❌ Error submitting request. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?> - Client Portal</title>
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
      <li><a href="submit_request.php" class="active">Submit Request</a></li>
      <li><a href="track_ticket.php">Track Ticket</a></li>
    </ul>
  </aside>

  <main>
    <h2><?= $title ?></h2>
    <p class="subtitle">Submit a new repair or maintenance request.</p>

    <?php if ($message): ?>
      <div class="card"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" class="card">
      <label for="description">Describe the issue:</label>
      <textarea name="description" placeholder="Describe your issue..." required></textarea>

      <label for="priority">Priority:</label>
      <select name="priority" required>
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
        <option value="urgent">Urgent</option>
      </select>

      <button type="submit" class="btn-primary">Submit Request</button>
    </form>
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
