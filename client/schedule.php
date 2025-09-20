<?php
include "../config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'client') {
    header("Location: ../login.php");
    exit();
}

$title = "Scheduled Work";
$username = $_SESSION['username'];

/*   Fetch scheduled work orders  AND pending service requests*/
$sql = "
(SELECT
    sr.id AS ticket_id,
    sr.description,
    NULL AS technician_name,
    sr.scheduled_date AS start_date,
    NULL AS due_date,
    sr.status,
    'Service Request' AS type_label
 FROM service_requests sr
 LEFT JOIN work_orders wo ON sr.id = wo.request_id
 WHERE sr.client_username = ? 
   AND sr.status = 'pending' 
   AND wo.request_id IS NULL)

UNION ALL

(SELECT
    sr.id AS ticket_id,
    sr.description,
    t.name AS technician_name,
    wo.start_date,
    wo.due_date,
    wo.status,
    'Work Order' AS type_label
 FROM work_orders wo
 JOIN service_requests sr ON wo.request_id = sr.id
 JOIN technicians t ON wo.technician_id = t.id
 WHERE sr.client_username = ? 
   AND wo.status != 'pending')

ORDER BY start_date ASC;
";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $username, $username);

if (!$stmt->execute()) {
    die("SQL Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("SQL get_result() failed: " . $stmt->error);
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
    <h1>Client Panel</h1>
    <a href="../logout.php" class="logout">Logout</a>
  </header>

  <div class="layout-flex">
    <aside>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="submit_request.php">Submit Request</a></li>
        <li><a href="track_ticket.php">Track Ticket</a></li>
        <li><a href="schedule.php" class="active">Scheduled Work</a></li>
        <li><a href="invoices.php">Invoices</a></li>
        <li><a href="profile.php">Profile</a></li>
      </ul>
    </aside>

    <main>
      <h2>Scheduled Work</h2>

      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
            $statusClass = strtolower($row['status']);

            // Due date
            $dueDateDisplay = "Not Scheduled";
            if (!empty($row['due_date']) && $row['due_date'] != "0000-00-00 00:00:00") {
                $dueDateDisplay = date("d M Y H:i", strtotime($row['due_date']));
                if ($row['status'] != 'completed' && strtotime($row['due_date']) < time()) {
                    $statusClass = "overdue";
                }
            } elseif ($statusClass == 'pending') {
                $dueDateDisplay = "Awaiting Assignment";
            }

            // Start date
            $startDateDisplay = "Not Scheduled";
            if (!empty($row['start_date']) && $row['start_date'] != "0000-00-00 00:00:00") {
                $startDateDisplay = date("d M Y H:i", strtotime($row['start_date']));
            }

            // Technician
            $technicianDisplay = $row['technician_name'] ?: "Unassigned";
            if ($statusClass == 'pending') {
                $technicianDisplay = "Unassigned";
            }
          ?>
          <div class="profile-card">
            <h3>Ticket #<?= $row['ticket_id'] ?> - 
              <span class="status-<?= str_replace(' ', '_', $statusClass) ?>">
                <?= ucfirst(str_replace('_', ' ', $statusClass)) ?>
              </span>
            </h3>
            <p><strong>Issue:</strong> <?= htmlspecialchars($row['description']) ?></p>
            <p><strong>Technician:</strong> <?= htmlspecialchars($technicianDisplay) ?></p>
            <p><strong>Start Date:</strong> <?= $startDateDisplay ?></p>
            <p><strong>Due Date:</strong> <?= $dueDateDisplay ?></p>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p>No scheduled work yet.</p>
      <?php endif; ?>
    </main>
  </div>
</body>
</html>
