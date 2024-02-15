<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_start();
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            
            // Check if user is superuser
            if ($row['superuser'] == 1) {
                $_SESSION['superuser'] = true; // Set superuser session variable
            }
            
            // Redirect to appropriate dashboard
            if ($_SESSION['superuser']) {
                header("Location: sdashboard.php?loginSuccess=true");
            } else {
                header("Location: user_dashboard.php?loginSuccess=true");
            }
            exit();
        } else {
            header("Location: login.php?loginError=true");
            exit();
        }
    } else {
        header("Location: login.php?loginError=true");
        exit();
    }
}
?>
