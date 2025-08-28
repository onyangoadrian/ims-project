<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
  header("Location: ../login.php");
  exit();
}

$title = "My Profile";
$username = $_SESSION['username'];
$message = "";

// ✅ Save or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? "";
    $email     = $_POST['email'] ?? "";
    $phone     = $_POST['phone'] ?? "";
    $address   = $_POST['address'] ?? "";

    // Check if client already exists
    $check = $conn->prepare("SELECT id FROM clients WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $result = $check->get_result();
    $exists = $result->num_rows > 0;
    $check->close();

    if ($exists) {
        // Update existing profile
        $update = $conn->prepare("UPDATE clients SET full_name=?, email=?, phone=?, address=? WHERE username=?");
        $update->bind_param("sssss", $full_name, $email, $phone, $address, $username);
        $update->execute();
        $update->close();
        $message = "Profile updated successfully.";
    } else {
        // Insert new profile row
        $insert = $conn->prepare("INSERT INTO clients (username, full_name, email, phone, address) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $username, $full_name, $email, $phone, $address);
        $insert->execute();
        $insert->close();
        $message = "Profile created successfully.";
    }
}

// ✅ Fetch client details (blank if not existing yet)
$sql = "SELECT * FROM clients WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$profile = $stmt->get_result()->fetch_assoc() ?? [];
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($title) ?></title>
  <link rel="stylesheet" href="../assets/style.css"> <!-- load theme -->
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
    <li><a href="invoices.php">Invoices</a></li>
    <li><a href="profile.php" class="active">My Profile</a></li>
  </ul>
</aside>

<main>
  <h2>My Profile</h2>

  <?php if (!empty($message)): ?>
    <div class="alert-success"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <div class="card">
    <form method="POST">
      <p><strong>Name:</strong> 
        <input type="text" name="full_name" value="<?= htmlspecialchars($profile['full_name'] ?? '') ?>" required>
      </p>
      <p><strong>Email:</strong> 
        <input type="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>" required>
      </p>
      <p><strong>Phone:</strong> 
        <input type="text" name="phone" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>" required>
      </p>
      <p><strong>Address:</strong> 
        <input type="text" name="address" value="<?= htmlspecialchars($profile['address'] ?? '') ?>" required>
      </p>
      <button type="submit" class="btn-save">Save</button>
    </form>
  </div>
</main>

</body>
</html>
