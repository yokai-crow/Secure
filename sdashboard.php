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

// Function to count files in a directory
function countFiles($dir) {
    $files = scandir($dir);
    $count = 0;
    foreach ($files as $file) {
        if (is_file($dir . '/' . $file)) {
            $count++;
        }
    }
    return $count;
}

// Define directory paths
$photosDir = 'assets/photos';
$videosDir = 'assets/videos';

// Count files in each directory
$totalPhotos = countFiles($photosDir);
$totalVideos = countFiles($videosDir);

// Fetch total number of superusers and normal users from the database
$sql = "SELECT COUNT(*) AS total FROM users WHERE superuser = 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalSuperusers = $row['total'];

$sql = "SELECT COUNT(*) AS total FROM users WHERE superuser = 0";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$totalNormalUsers = $row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" type="image/png" href="./assets/pageAssets/tab.png"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <div class="col-md-6">
                <h2>Total Files</h2>
                <canvas id="fileCountChart" width="400" height="400"></canvas>
            </div>
            <div class="col-md-6">
                <h2>Total Users</h2>
                <canvas id="userCountChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Get the file counts from PHP
        var totalPhotos = <?php echo $totalPhotos; ?>;
        var totalVideos = <?php echo $totalVideos; ?>;

        // Create a pie chart for file counts
        var ctx1 = document.getElementById('fileCountChart').getContext('2d');
        var fileCountChart = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['Photos', 'Videos'],
                datasets: [{
                    label: 'File Counts',
                    data: [totalPhotos, totalVideos],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: true
            }
        });

        // Get the user counts from PHP
        var totalSuperusers = <?php echo $totalSuperusers; ?>;
        var totalNormalUsers = <?php echo $totalNormalUsers; ?>;

        // Create a bar chart for user counts
        var ctx2 = document.getElementById('userCountChart').getContext('2d');
        var userCountChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Superusers', 'Normal Users'],
                datasets: [{
                    label: 'User Counts',
                    data: [totalSuperusers, totalNormalUsers],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
