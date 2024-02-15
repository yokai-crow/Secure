<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Check if superuser checkbox is checked
    $superuser = isset($_POST['superuser']) ? 1 : 0;

    $sql = "INSERT INTO users (username, email, password, superuser) VALUES ('$username', '$email', '$password', $superuser)";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
