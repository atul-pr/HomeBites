<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if(isset($_GET['id'])) {
    $food_id = $_GET['id'];
    
    // Check if food item exists
    $check_query = mysqli_query($con, "SELECT f.*, v.fld_email FROM tbfood f 
                                      JOIN tblvendor v ON f.fldvendor_id = v.fldvendor_id 
                                      WHERE f.food_id='$food_id'");
    
    if(mysqli_num_rows($check_query) == 0) {
        $_SESSION['error'] = "Food item not found!";
        header("location:admin-dashboard.php#food");
        exit();
    }
    
    $food = mysqli_fetch_assoc($check_query);
    $email = $food['fld_email'];
    $image = $food['fldimage'];
    
    // Delete food item
    $delete_query = mysqli_query($con, "DELETE FROM tbfood WHERE food_id='$food_id'");
    
    if($delete_query) {
        // Delete food image
        $image_path = "../image/restaurant/$email/foodimages/$image";
        if(file_exists($image_path)) {
            unlink($image_path);
        }
        
        $_SESSION['success'] = "Food item deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete food item: " . mysqli_error($con);
    }
    
    header("location:admin-dashboard.php#food");
    exit();
} else {
    header("location:admin-dashboard.php#food");
    exit();
}
?>

