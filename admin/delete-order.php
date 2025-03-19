<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if(isset($_GET['id'])) {
    $order_id = $_GET['id'];
    
    // Check if order exists
    $check_query = mysqli_query($con, "SELECT * FROM tblorder WHERE fld_order_id='$order_id'");
    if(mysqli_num_rows($check_query) == 0) {
        $_SESSION['error'] = "Order not found!";
        header("location:admin-dashboard.php#orders");
        exit();
    }
    
    // Delete order
    $delete_query = mysqli_query($con, "DELETE FROM tblorder WHERE fld_order_id='$order_id'");
    
    if($delete_query) {
        $_SESSION['success'] = "Order deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete order: " . mysqli_error($con);
    }
    
    header("location:admin-dashboard.php#orders");
    exit();
} else {
    header("location:admin-dashboard.php#orders");
    exit();
}
?>

