<?php
session_start();
include("../connection.php");
extract($_REQUEST);
$product_id = isset($_GET['product']) ? $_GET['product'] : "";
$loginmsg = isset($_GET['msg']) ? $_GET['msg'] : "";

if (isset($register)) {
    $query = mysqli_query($con, "SELECT * FROM tblcustomer WHERE fld_email='$email'");
    $row = mysqli_num_rows($query);
    if ($row) {
        $ermsg2 = "Email already registered";
    } else {
        $preference = implode(",", $chk);
        if (mysqli_query($con, "INSERT INTO tblcustomer (fld_name, fld_email, password, fld_mobile, fld_preference) VALUES ('$name', '$email', '$password', '$mobile', '$preference')")) {
            $_SESSION['cust_id'] = $email;
            if (!empty($customer_email) && $product_id) {
                $_SESSION['cust_id'] = $customer_email;
                header("location:cart.php?product=$product_id");
            } else {
                $_SESSION['cust_id'] = $email;
                header("location:../index.php");
            }
        } else {
            echo "Registration failed. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HomeBites - Sign Up</title>
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
        .signup-container {
            width: 100%;
            max-width: 400px;
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
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand text-white" href="../index.php"><i class="fas fa-utensils"></i> HomeBites</a>
        </div>
    </nav>
    <div class="signup-container">
        <h3 class="text-center">Sign Up</h3>
        <div class="text-danger text-center">
            <?php if (isset($ermsg)) { echo $ermsg; }?>
            <?php if (isset($ermsg2)) { echo $ermsg2; }?>
        </div>
        <form method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="pwd">Password</label>
                <input type="password" name="password" class="form-control" id="pwd" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="tel" id="mobile" class="form-control" name="mobile" pattern="[6-9]{1}[0-9]{9}" required>
            </div>
            <div class="form-group">
                <label for="food-preference">Food Type Preference</label><br>
                <input type="radio" name="chk[]" value="Veg" required> Veg<br>
                <input type="radio" name="chk[]" value="Non-Veg" required> Non-Veg
            </div>
            <button type="submit" name="register" class="btn btn-custom btn-block text-white">Create New Account</button>
        </form>
    </div>
</body>
</html>
