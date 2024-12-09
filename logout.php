<?php
session_start(); // Start the session

// Unset the user session variable
unset($_SESSION['user']);

// Destroy the session
session_destroy();

// Redirect to loginpage.php
header("Location: loginpage.php");
exit(); // Ensure no further code is executed
?>
