<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Prevent caching of the page
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Include database connection script
require_once 'db.php';

// Check if the ID parameter is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redirect to info.php if ID is not provided or not valid
    header("Location: info.php");
    exit();
}

$id = $_GET['id'];

// Fetch media details from the database
$sql = "SELECT * FROM media WHERE id = $id";
$result = mysqli_query($conn, $sql);

// Check if the media exists
if (mysqli_num_rows($result) == 0) {
    // Redirect to info.php if the media doesn't exist
    header("Location: info.php");
    exit();
}

$row = mysqli_fetch_assoc($result);

// Check if user is authorized to delete media (superuser or owner of the media)
if ($_SESSION['superuser'] || $row['uploaded_by'] == $_SESSION['user_id']) {
    // Perform deletion from the database
    $delete_sql = "DELETE FROM media WHERE id = $id";
    if (mysqli_query($conn, $delete_sql)) {
        // Delete the associated file from the filesystem (optional, depending on your application)
        
        // Redirect to info.php after successful deletion
        header("Location: info.php");
        exit();
    } else {
        // Handle error
        $error_message = "Error deleting media: " . mysqli_error($conn);
    }
} else {
    // Redirect to info.php if user is not authorized to delete media
    header("Location: info.php");
    exit();
}
?>
