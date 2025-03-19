<?php
session_start();
include("../connection.php");
extract($_REQUEST);

if(isset($_SESSION['admin_id'])) {
    header("location:admin-dashboard.php");
}

if(isset($login)) {
    // Admin credentials check
    if($username == "admin@homebites.com" && $pswd == "admin123") {
        $_SESSION['admin_id'] = $username;
        header('location:admin-dashboard.php');
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
    <title>HomeBites | Admin Login</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
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
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .login-container h3 {
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }
        .btn-login {
            background-color:rgb(54, 145, 209);
            border: none;
            padding: 12px;
            font-size: 16px;
            width: 100%;
            color: white;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color:rgb(46, 125, 205);
            transform: translateY(-2px);
        }
        .admin-icon {
            font-size: 50px;
            color: #343a40;
            margin-bottom: 20px;
        }
        .back-link {
            margin-top: 20px;
            color: #6c757d;
            text-decoration: none;
        }
        .back-link:hover {
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="admin-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <h3>Admin Login</h3>
        <div class="text-danger mb-3">
            <?php if(isset($admin_login_error)) { echo $admin_login_error; } ?>
        </div>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Email:</label>
                <input type="email" class="form-control" id="username" name="username" placeholder="Enter Admin Email" required/>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" name="pswd" placeholder="Enter Password" required/>
            </div>
            <button type="submit" name="login" class="btn btn-login">Login</button>
        </form>
        <a href="../index.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to HomeBites
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

