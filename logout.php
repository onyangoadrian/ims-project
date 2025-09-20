<link rel="stylesheet" href="../assets/style.css">
<?php
session_start();          // Start 
session_unset();          // Remove all session variables
session_destroy();        // end 

// Redirect to login page
header("Location: login.php");
exit();
?>