<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $r_name = $_POST['r_name'];
    $email = $_POST['email'];
    $password = $_POST['pswd'];
    $mobile = $_POST['mob'];
    $address = $_POST['address'];
    
    // Check if email already exists
    $check_query = mysqli_query($con, "SELECT * FROM tblvendor WHERE fld_email='$email'");
    if(mysqli_num_rows($check_query) > 0) {
        $_SESSION['error'] = "Email already exists!";
        header("location:admin-dashboard.php#restaurants");
        exit();
    }
    
    // Handle logo upload
    $logo = $_FILES['logo']['name'];
    $temp_logo = $_FILES['logo']['tmp_name'];
    
    // Insert new restaurant
    $insert_query = mysqli_query($con, "INSERT INTO tblvendor (fld_name, fld_email, fld_password, fld_mob, fld_address, fld_logo) 
                                        VALUES ('$r_name', '$email', '$password', '$mobile', '$address', '$logo')");
    
    if($insert_query) {
        // Create directory for restaurant images
        mkdir("../image/restaurant/$email", 0777, true);
        
        // Move uploaded logo
        move_uploaded_file($temp_logo, "../image/restaurant/$email/$logo");
        
        $_SESSION['success'] = "Restaurant added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add restaurant: " . mysqli_error($con);
    }
    
    header("location:admin-dashboard.php#restaurants");
    exit();
}
?>

