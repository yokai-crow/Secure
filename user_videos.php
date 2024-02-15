<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include database connection script
require_once 'db.php';

// Fetch all videos from the database
$sql = "SELECT * FROM media WHERE file_type = 'video'";
$result = mysqli_query($conn, $sql);

// Check if videos exist
if (mysqli_num_rows($result) == 0) {
    $message = "No videos found.";
} else {
    $videos = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./assets/pageAssets/tab.png"/>
    <title>All Videos</title>
    <link rel="icon" type="image/png" href="./assets/pageAssets/tab.png"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">User Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="user_dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_videos.php">Videos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="user_images.php">Images</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <img src="./publicAssets/pp.png" alt="Profile Picture" class="nav-link img-fluid" style="max-height: 40px;">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>All Videos</h2>
        <?php if (isset($message)) : ?>
            <div class="alert alert-info" role="alert">
                <?php echo $message; ?>
            </div>
        <?php else : ?>
            <div class="row">
                <?php foreach ($videos as $video) : ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <?php if (isset($video['filename'])) : ?>
                                    <h5 class="card-title"><?php echo $video['filename']; ?></h5>
                                <?php else : ?>
                                    <h5 class="card-title">Untitled Video</h5>
                                <?php endif; ?>
                                <video width="100%" controls>
                                    <source src="<?php echo $video['filepath']; ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
