<?php
session_start();

// Include the database connection file
require_once('dbconn.php');

// Insert a log entry for logout
$log_sql = "INSERT INTO Logs (user_id, action, date, time) VALUES ('{$_SESSION['user_id']}', 'Logout', CURDATE(), CURTIME())";
mysqli_query($connection, $log_sql);

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: _login.php");
exit();
?>
