<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if(!isset($_GET['id'])) {
    header("location:admin-dashboard.php#users");
    exit();
}

$user_id = $_GET['id'];
$user_query = mysqli_query($con, "SELECT * FROM tblcustomer WHERE fld_cust_id='$user_id'");

if(mysqli_num_rows($user_query) == 0) {
    $_SESSION['error'] = "User not found!";
    header("location:admin-dashboard.php#users");
    exit();
}

$user = mysqli_fetch_assoc($user_query);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $preference = $_POST['preference'];
    $password = $_POST['password'];
    
    // Check if email already exists (excluding current user)
    $check_query = mysqli_query($con, "SELECT * FROM tblcustomer WHERE fld_email='$email' AND fld_cust_id != '$user_id'");
    if(mysqli_num_rows($check_query) > 0) {
        $error = "Email already exists!";
    } else {
        // Update user
        $update_query = mysqli_query($con, "UPDATE tblcustomer SET 
                                            fld_name='$name', 
                                            fld_email='$email', 
                                            fld_mobile='$mobile', 
                                            fld_preference='$preference'
                                            " . (!empty($password) ? ", password='$password'" : "") . "
                                            WHERE fld_cust_id='$user_id'");
        
        if($update_query) {
            $_SESSION['success'] = "User updated successfully!";
            header("location:admin-dashboard.php#users");
            exit();
        } else {
            $error = "Failed to update user: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HomeBites | Edit User</title>
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
                <a class="nav-link" href="admin-dashboard.php#users">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="mb-4">Edit User</h2>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['fld_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['fld_email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="tel" class="form-control" id="mobile" name="mobile" pattern="[7-9]{1}[0-9]{9}" value="<?php echo $user['fld_mobile']; ?>" required>
            </div>
            <div class="form-group">
                <label for="preference">Preference</label>
                <select class="form-control" id="preference" name="preference" required>
                    <option value="Veg" <?php if($user['fld_preference'] == 'Veg') echo 'selected'; ?>>Vegetarian</option>
                    <option value="Non-Veg" <?php if($user['fld_preference'] == 'Non-Veg') echo 'selected'; ?>>Non-Vegetarian</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password (Leave blank to keep current password)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="admin-dashboard.php#users" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

