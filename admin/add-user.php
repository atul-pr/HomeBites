<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $preference = $_POST['preference'];
    $password = $_POST['password'];
    
    // Check if email already exists
    $check_query = mysqli_query($con, "SELECT * FROM tblcustomer WHERE fld_email='$email'");
    if(mysqli_num_rows($check_query) > 0) {
        $_SESSION['error'] = "Email already exists!";
        header("location:admin-dashboard.php#users");
        exit();
    }
    
    // Insert new user
    $insert_query = mysqli_query($con, "INSERT INTO tblcustomer (fld_name, fld_email, fld_mobile, fld_preference, password) 
                                        VALUES ('$name', '$email', '$mobile', '$preference', '$password')");
    
    if($insert_query) {
        $_SESSION['success'] = "User added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add user: " . mysqli_error($con);
    }
    
    header("location:admin-dashboard.php#users");
    exit();
}
?>

