<?php
session_start();
// Destroy the session
session_destroy();
// Ensure that all session data is removed
$_SESSION = [];
// Redirect to the login page
header("Location: login.php");
exit();
?>
