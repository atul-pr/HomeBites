<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if(isset($_GET['id'])) {
    $restaurant_id = $_GET['id'];
    
    // Check if restaurant exists
    $check_query = mysqli_query($con, "SELECT * FROM tblvendor WHERE fldvendor_id='$restaurant_id'");
    if(mysqli_num_rows($check_query) == 0) {
        $_SESSION['error'] = "Restaurant not found!";
        header("location:admin-dashboard.php#restaurants");
        exit();
    }
    
    $restaurant = mysqli_fetch_assoc($check_query);
    $email = $restaurant['fld_email'];
    
    // Delete restaurant
    $delete_query = mysqli_query($con, "DELETE FROM tblvendor WHERE fldvendor_id='$restaurant_id'");
    
    if($delete_query) {
        // Delete associated food items
        mysqli_query($con, "DELETE FROM tbfood WHERE fldvendor_id='$restaurant_id'");
        
        // Delete restaurant directory (optional)
        // This is commented out for safety - you might want to keep the images
        // deleteDirectory("../image/restaurant/$email");
        
        $_SESSION['success'] = "Restaurant deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete restaurant: " . mysqli_error($con);
    }
    
    header("location:admin-dashboard.php#restaurants");
    exit();
} else {
    header("location:admin-dashboard.php#restaurants");
    exit();
}

// Function to delete directory and its contents
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }

    return rmdir($dir);
}
?>

