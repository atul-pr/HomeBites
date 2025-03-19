<?php
session_start();
include("connection.php");
extract($_REQUEST);

if (isset($_SESSION['id'])) {
    header("location:dashboard.php");
}

if (isset($register)) {
    $sql = mysqli_query($con, "SELECT * FROM tblvendor WHERE fld_email='$email'");
    if (mysqli_num_rows($sql)) {
        $email_error = "This Email Id is already registered with us";
    } else {
        $logo = $_FILES['logo']['name'];
        $sql = mysqli_query($con, "INSERT INTO tblvendor (fld_name, fld_email, fld_password, fld_mob, fld_address, fld_logo) VALUES ('$r_name','$email','$pswd','$mob','$address','$logo')");
        
        if ($sql) {
            mkdir("image/restaurant/$email", 0777, true);
            move_uploaded_file($_FILES['logo']['tmp_name'], "image/restaurant/$email/" . $_FILES['logo']['name']);
            $_SESSION['id'] = $email;
            header("location:dashboard.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeBites | Restaurant Sign Up</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>

    <style>
        body { 
            background: #f8f9fa; 
            padding-top: 70px; /* Offset for fixed navbar */
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

        /* Register Form Container */
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Custom Button */
        .btn-custom {
            background: #ED2553;
            color: white;
        }

        .btn-custom:hover {
            background: #c71d42;
        }
    </style>
</head>
<body>

<!-- Responsive Transparent Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand mx-auto" href="index.php">
            <i class="fas fa-utensils"></i> HomeBites
        </a>
    </div>
</nav>


<div class="container">
    <div class="register-container">
        <h3 class="text-center">Register Your Restaurant</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="r_name" value="<?php if(isset($r_name)) { echo $r_name; } ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="<?php if(isset($email)) { echo $email; } ?>" required>
                <small class="text-danger"><?php if(isset($email_error)) { echo $email_error; } ?></small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="pswd" required>
            </div>
            <div class="form-group">
                <label>Mobile</label>
                <input type="tel" class="form-control" pattern="[7-9]{1}[0-9]{9}" name="mob" value="<?php if(isset($mob)) { echo $mob; } ?>" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="address" value="<?php if(isset($address)) { echo $address; } ?>" required>
            </div>
            <div class="form-group">
                <label>Upload Logo</label>
                <input type="file" name="logo" class="form-control-file" required>
            </div>
            <button type="submit" name="register" class="btn btn-custom btn-block">Register</button>
            <p class="text-center mt-3">Already have an account? <a href="sellerSignIn.php">Login</a></p>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
