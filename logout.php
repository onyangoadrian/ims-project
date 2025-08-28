<link rel="stylesheet" href="../assets/style.css">
<?php
session_start();          // Start the session
session_unset();          // Remove all session variables
session_destroy();        // Destroy the session

// Redirect to login page
header("Location: login.php");
exit();
?>