<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" type="image/png" href="./assets/pageAssets/tab.png"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .container {
            margin-top: 50px; /* Add some top margin for better alignment */
            text-align: center; /* Center align the content */
            background-image: url('./publicAssets/login.png'); /* Set background image */
            background-size: cover; /* Cover the entire container */
            background-position: center; /* Center the background image */
            padding: 50px; /* Add padding for spacing */
            border-radius: 10px; /* Add border radius for rounded corners */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
            max-width: 400px; /* Limit width for better readability */
            margin-left: auto; /* Center the container horizontally */
            margin-right: auto; /* Center the container horizontally */
        }
        h2 {
            margin-bottom: 20px; /* Add some bottom margin for spacing */
            color: #444; /* White text color */
        }
        form {
            margin-top: 20px; /* Add some top margin for spacing */
        }
        .form-control {
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background for inputs */
        }
        .btn {
            margin: 5px; /* Add margin around buttons for spacing */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-success">Register</a>
        </form>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php if(isset($_GET['loginError']) && $_GET['loginError'] == 'true'): ?>
        <script>
            $(document).ready(function(){
                $('#loginErrorModal').modal('show');
            });
        </script>
    <?php endif; ?>

    <!-- Error Modal -->
    <div class="modal fade" id="loginErrorModal" tabindex="-1" role="dialog" aria-labelledby="loginErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginErrorModalLabel">Login Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Invalid username or password. Please try again.
                </div>
            </div>
        </div>
    </div>
</body>
</html>
