<link rel="stylesheet" href="../assets/style.css">
<?php
$host = "localhost";
$user = "root";  // default XAMPP user
$pass = "";      // default XAMPP password is empty
$db   = "ims_project";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
