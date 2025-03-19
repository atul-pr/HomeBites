<?php
session_start();
include("../connection.php");
extract($_REQUEST);
$product_id = isset($_GET['product']) ? $_GET['product'] : "";
$loginmsg = isset($_GET['msg']) ? $_GET['msg'] : "";

if (isset($login)) {
    $query = mysqli_query($con, "SELECT * FROM tblcustomer WHERE fld_email='$email' AND password='$password'");
    if ($row = mysqli_fetch_array($query)) {
        $_SESSION['cust_id'] = $row['fld_email'];
        if (!empty($_SESSION['cust_id']) && $product_id) {
            header("location:cart.php?product=$product_id");
        } else {
            header("location:../index.php");
        }
    } else {
        $ermsg = "Email or Password is incorrect";
    }
}

if (isset($signup)) {
    header("location:form/userSignup?product=$product_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomeBites - Login</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>
    <style>
        body {
            
            background: url('../assets/images/wall.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            margin-top: 60px; /* Prevent navbar overlap */
        }
        
        /* Navbar */
        .navbar {
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        .navbar .container {
            display: flex;
            justify-content: center;
        }
        .navbar .navbar-brand {
            font-size: 24px;
            font-weight: bold;
        }

        .login-container {
            width: 100%;
            max-width: 360px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .btn-custom {
            background: #ED2553;
            border: none;
        }
        .btn-custom:hover {
            background: #c71f44;
        }
    </style>
</head>
<body>

    <!-- Navbar with centered HomeBites -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="../index.php"><i class="fas fa-utensils"></i> HomeBites</a>
        </div>
    </nav>

    <div class="login-container">
        <h3 class="text-center">Log In</h3>
        <div class="text-danger text-center"><?php echo $loginmsg; ?></div>
        <form method="post">
            <div class="form-group">
                <label for="email">Email address:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" name="password" class="form-control" id="pwd" required>
            </div>
            <button type="submit" name="login" class="btn btn-custom btn-block text-white">Log In</button>
            <p class="mt-3 text-center">Don't have an account? <a href="userSignup.php?product=<?php echo $product_id; ?>">Sign Up</a></p>
            <div class="text-danger text-center"><?php echo isset($ermsg) ? $ermsg : ''; ?></div>
        </form>
    </div>

</body>
</html>
