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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if file type is specified (photo or video)
    if (isset($_POST['file_type'])) {
        // Define upload directory path based on file type
        $uploadDir = $_POST['file_type'] === 'photo' ? './assets/photos/' : './assets/videos/';

        // Define full path for uploading
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);

        // Check if file size is within limit
        if ($_FILES['file']['size'] > 500000000) {
            echo "Sorry, your file is too large.";
            exit();
        }

        // Move uploaded file to destination directory
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            // File uploaded successfully
            echo "The file " . htmlspecialchars(basename($_FILES['file']['name'])) . " has been uploaded.";

            // Store file details in the database
            $filename = basename($_FILES['file']['name']);
            $fileType = $_POST['file_type'];
            $userId = $_SESSION['user_id'];
            $uploadedAt = date('Y-m-d H:i:s');

            // Prepare SQL statement to insert file details
            $sql = "INSERT INTO media (filename, filepath, file_type, uploaded_by, uploaded_at) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            // Bind parameters and execute the statement
            mysqli_stmt_bind_param($stmt, "sssss", $filename, $uploadFile, $fileType, $userId, $uploadedAt);
            mysqli_stmt_execute($stmt);

            // Check if insertion was successful
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo ", success";
            } else {
                echo ", Error inserting file details into database: " . mysqli_error($conn);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File type not specified.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Media</title>
    <link rel="icon" type="image/png" href="./assets/pageAssets/tab.png"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="sdashboard.php">Home</a>
                    </li>
                    <?php if(isset($_SESSION['superuser']) && $_SESSION['superuser']): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="upload.php">Upload</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="user.php">Users Info</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="info.php">Media Info</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <h2>Upload Media</h2>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Select File:</label>
                        <input type="file" class="form-control-file" id="file" name="file" required>
                    </div>
                    <div class="form-group">
                        <label for="file_type">File Type:</label>
                        <select class="form-control" id="file_type" name="file_type" required>
                            <option value="photo">Photo</option>
                            <option value="video">Video</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
