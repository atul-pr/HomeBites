<?php
session_start();
include("connection.php");
extract($_REQUEST);

if (isset($_SESSION['id'])) {
    header("location:food.php");
}

if (isset($login)) {
    $sql = mysqli_query($con, "SELECT * FROM tblvendor WHERE fld_email='$username' AND fld_password='$pswd'");
    if (mysqli_num_rows($sql)) {
        $_SESSION['id'] = $username;
        header('location:dashboard.php');
    } else {
        $admin_login_error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HomeBites | Restaurant Login</title>

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        /* Transparent Navbar */
        .navbar {
            background: rgba(0, 0, 0, 0.7) !important;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
        }

        /* Centered Login Container */
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container h3 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-group {
            text-align: left;
        }

        .btn-login {
            background-color: #ED2553;
            border: none;
            padding: 10px;
            font-size: 16px;
            width: 100%;
            color: white;
            border-radius: 5px;
        }

        .btn-login:hover {
            background-color: #c51d42;
        }

        .register-link {
            margin-top: 10px;
            display: block;
        }
    </style>
</head>
<body>

<!-- Transparent Dark Navbar with Centered HomeBites -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container d-flex justify-content-center">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-utensils"></i> HomeBites
        </a>
    </div>
</nav>


<!-- Centered Login Form -->
<div class="login-container">
    <h3>Restaurant Login</h3>
    <div class="footer text-danger">
        <?php if (isset($admin_login_error)) { echo $admin_login_error; } ?>
    </div>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Email:</label>
            <input type="email" class="form-control" id="username" name="username" placeholder="Enter Email" required/>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pswd" placeholder="Enter Password" required/>
        </div>
        <button type="submit" name="login" class="btn btn-login">Login</button>
    </form>
    <a href="sellerSignUp.php" class="register-link">Don't have an account? Register</a>
</div>

<!-- Bootstrap Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
