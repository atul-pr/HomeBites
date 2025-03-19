<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if(isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Check if user exists
    $check_query = mysqli_query($con, "SELECT * FROM tblcustomer WHERE fld_cust_id='$user_id'");
    if(mysqli_num_rows($check_query) == 0) {
        $_SESSION['error'] = "User not found!";
        header("location:admin-dashboard.php#users");
        exit();
    }
    
    // Delete user
    $delete_query = mysqli_query($con, "DELETE FROM tblcustomer WHERE fld_cust_id='$user_id'");
    
    if($delete_query) {
        $_SESSION['success'] = "User deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete user: " . mysqli_error($con);
    }
    
    header("location:admin-dashboard.php#users");
    exit();
} else {
    header("location:admin-dashboard.php#users");
    exit();
}
?>

