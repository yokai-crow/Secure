<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if user is not a superuser
if (!isset($_SESSION['superuser']) || !$_SESSION['superuser']) {
    header("Location: sdashboard.php");
    exit();
}

// Include database connection script
require_once 'db.php';

// Check if the ID parameter is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to user.php if ID is not provided or not valid
    header("Location: user.php");
    exit();
}

$id = $_GET['id'];

// Delete user from the database
$sql = "DELETE FROM users WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    // Redirect to user.php after successful deletion
    header("Location: user.php");
    exit();
} else {
    // Handle error
    echo "Error deleting user: " . mysqli_error($conn);
}
?>
