<?php
include "../config.php";
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$title = "Inventory";

// Fetch inventory
$result = $conn->query("SELECT * FROM inventory ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="../assets/style.css">
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background: #2c3e50;
      color: #fff;
    }
    .low { color: red; font-weight: bold; }
    .good { color: green; font-weight: bold; }
    .restock-form {
      margin-top: 20px;
      padding: 15px;
      border: 1px solid #ddd;
      background: #f9f9f9;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <header>
    <h1>Admin Panel - Inventory</h1>
    <a href="../logout.php" class="logout">Logout</a>
  </header>

  <aside>
    <ul>
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="inventory.php" class="active">Inventory</a></li>
      <li><a href="requests.php">Service Requests</a></li>
      <li><a href="workorders.php">Work Orders</a></li>
      <li><a href="technicians.php">Technicians</a></li>
      <li><a href="reports.php">Reports</a></li>
    </ul>
  </aside>

  <main>
    <h2>Inventory List</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Part Name</th>
        <th>Quantity</th>
        <th>Price (Ksh)</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td class="<?= ($row['quantity'] < 10) ? 'low' : 'good' ?>">
          <?= $row['quantity'] ?>
        </td>
        <td>Ksh <?= number_format($row['price'], 2) ?></td>
      </tr>
      <?php endwhile; ?>
    </table>

    <!-- Restock Form -->
    <div class="restock-form">
      <h3>Restock Inventory</h3>
      <form method="post" action="">
        <label for="part_id">Part ID:</label>
        <input type="number" name="part_id" required>
        <label for="quantity">Quantity to Add:</label>
        <input type="number" name="quantity" required>
        <button type="submit" name="restock">Restock</button>
      </form>
    </div>

    <?php
    // Handle restock
    if (isset($_POST['restock'])) {
        $part_id = intval($_POST['part_id']);
        $quantity = intval($_POST['quantity']);
        $conn->query("UPDATE inventory SET quantity = quantity + $quantity WHERE id = $part_id");
        echo "<p style='color:green;'>Inventory updated successfully!</p>";
        echo "<meta http-equiv='refresh' content='1'>"; // refresh page to reflect update
    }
    ?>
  </main>
</body>
</html>
