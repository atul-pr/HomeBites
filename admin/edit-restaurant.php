<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if(!isset($_GET['id'])) {
    header("location:admin-dashboard.php#restaurants");
    exit();
}

$restaurant_id = $_GET['id'];
$restaurant_query = mysqli_query($con, "SELECT * FROM tblvendor WHERE fldvendor_id='$restaurant_id'");

if(mysqli_num_rows($restaurant_query) == 0) {
    $_SESSION['error'] = "Restaurant not found!";
    header("location:admin-dashboard.php#restaurants");
    exit();
}

$restaurant = mysqli_fetch_assoc($restaurant_query);
$old_email = $restaurant['fld_email'];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $r_name = $_POST['r_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mob'];
    $address = $_POST['address'];
    $password = $_POST['pswd'];
    
    // Check if email already exists (excluding current restaurant)
    $check_query = mysqli_query($con, "SELECT * FROM tblvendor WHERE fld_email='$email' AND fldvendor_id != '$restaurant_id'");
    if(mysqli_num_rows($check_query) > 0) {
        $error = "Email already exists!";
    } else {
        // Handle logo upload if provided
        if(!empty($_FILES['logo']['name'])) {
            $logo = $_FILES['logo']['name'];
            $temp_logo = $_FILES['logo']['tmp_name'];
            
            // Update with new logo
            $update_query = mysqli_query($con, "UPDATE tblvendor SET 
                                                fld_name='$r_name', 
                                                fld_email='$email', 
                                                fld_mob='$mobile', 
                                                fld_address='$address', 
                                                fld_logo='$logo'
                                                " . (!empty($password) ? ", fld_password='$password'" : "") . "
                                                WHERE fldvendor_id='$restaurant_id'");
            
            if($update_query) {
                // If email changed, rename directory
                if($email != $old_email) {
                    rename("../image/restaurant/$old_email", "../image/restaurant/$email");
                }
                
                // Move uploaded logo
                move_uploaded_file($temp_logo, "../image/restaurant/$email/$logo");
                
                $_SESSION['success'] = "Restaurant updated successfully!";
                header("location:admin-dashboard.php#restaurants");
                exit();
            } else {
                $error = "Failed to update restaurant: " . mysqli_error($con);
            }
        } else {
            // Update without changing logo
            $update_query = mysqli_query($con, "UPDATE tblvendor SET 
                                                fld_name='$r_name', 
                                                fld_email='$email', 
                                                fld_mob='$mobile', 
                                                fld_address='$address'
                                                " . (!empty($password) ? ", fld_password='$password'" : "") . "
                                                WHERE fldvendor_id='$restaurant_id'");
            
            if($update_query) {
                // If email changed, rename directory
                if($email != $old_email) {
                    rename("../image/restaurant/$old_email", "../image/restaurant/$email");
                }
                
                $_SESSION['success'] = "Restaurant updated successfully!";
                header("location:admin-dashboard.php#restaurants");
                exit();
            } else {
                $error = "Failed to update restaurant: " . mysqli_error($con);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HomeBites | Edit Restaurant</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 56px;
        }
        .container {
            max-width: 600px;
            margin-top: 30px;
            background: white;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,.1);
        }
        .current-logo {
            max-width: 100px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="admin-dashboard.php">
            <i class="fas fa-utensils"></i> HomeBites Admin
        </a>
        <ul class="navbar-nav px-3 ml-auto">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="admin-dashboard.php#restaurants">
                    <i class="fas fa-arrow-left"></i> Back to Restaurants
                </a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="mb-4">Edit Restaurant</h2>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="r_name">Restaurant Name</label>
                <input type="text" class="form-control" id="r_name" name="r_name" value="<?php echo $restaurant['fld_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $restaurant['fld_email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="mob">Mobile</label>
                <input type="tel" class="form-control" id="mob" name="mob" pattern="[7-9]{1}[0-9]{9}" value="<?php echo $restaurant['fld_mob']; ?>" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $restaurant['fld_address']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="pswd">Password (Leave blank to keep current password)</label>
                <input type="password" class="form-control" id="pswd" name="pswd">
            </div>
            <div class="form-group">
                <label>Current Logo</label><br>
                <img src="../image/restaurant/<?php echo $restaurant['fld_email']; ?>/<?php echo $restaurant['fld_logo']; ?>" class="current-logo rounded">
            </div>
            <div class="form-group">
                <label for="logo">Change Logo (Leave blank to keep current logo)</label>
                <input type="file" class="form-control-file" id="logo" name="logo">
            </div>
            <button type="submit" class="btn btn-primary">Update Restaurant</button>
            <a href="admin-dashboard.php#restaurants" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

