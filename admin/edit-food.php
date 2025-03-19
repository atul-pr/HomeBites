<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if(!isset($_GET['id'])) {
    header("location:admin-dashboard.php#food");
    exit();
}

$food_id = $_GET['id'];
$food_query = mysqli_query($con, "SELECT f.*, v.fld_name as vendor_name, v.fld_email 
                                 FROM tbfood f 
                                 JOIN tblvendor v ON f.fldvendor_id = v.fldvendor_id 
                                 WHERE f.food_id='$food_id'");

if(mysqli_num_rows($food_query) == 0) {
    $_SESSION['error'] = "Food item not found!";
    header("location:admin-dashboard.php#food");
    exit();
}

$food = mysqli_fetch_assoc($food_query);

// Get all restaurants for dropdown
$restaurants = mysqli_query($con, "SELECT * FROM tblvendor ORDER BY fld_name");

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $foodname = $_POST['foodname'];
    $cost = $_POST['cost'];
    $cuisines = $_POST['cuisines'];
    $paymentmode = $_POST['paymentmode'];
    $vendor_id = $_POST['vendor_id'];
    
    // Get vendor email for file operations
    $vendor_query = mysqli_query($con, "SELECT fld_email FROM tblvendor WHERE fldvendor_id='$vendor_id'");
    $vendor = mysqli_fetch_assoc($vendor_query);
    $vendor_email = $vendor['fld_email'];
    
    // Handle image upload if provided
    if(!empty($_FILES['food_pic']['name'])) {
        $image = $_FILES['food_pic']['name'];
        $temp_image = $_FILES['food_pic']['tmp_name'];
        
        // Update with new image
        $update_query = mysqli_query($con, "UPDATE tbfood SET 
                                            foodname='$foodname', 
                                            cost='$cost', 
                                            cuisines='$cuisines', 
                                            paymentmode='$paymentmode', 
                                            fldvendor_id='$vendor_id', 
                                            fldimage='$image' 
                                            WHERE food_id='$food_id'");
        
        if($update_query) {
            // Create foodimages directory if it doesn't exist
            if(!file_exists("../image/restaurant/$vendor_email/foodimages")) {
                mkdir("../image/restaurant/$vendor_email/foodimages", 0777, true);
            }
            
            // Move uploaded image
            move_uploaded_file($temp_image, "../image/restaurant/$vendor_email/foodimages/$image");
            
            $_SESSION['success'] = "Food item updated successfully!";
            header("location:admin-dashboard.php#food");
            exit();
        } else {
            $error = "Failed to update food item: " . mysqli_error($con);
        }
    } else {
        // Update without changing image
        $update_query = mysqli_query($con, "UPDATE tbfood SET 
                                            foodname='$foodname', 
                                            cost='$cost', 
                                            cuisines='$cuisines', 
                                            paymentmode='$paymentmode', 
                                            fldvendor_id='$vendor_id' 
                                            WHERE food_id='$food_id'");
        
        if($update_query) {
            $_SESSION['success'] = "Food item updated successfully!";
            header("location:admin-dashboard.php#food");
            exit();
        } else {
            $error = "Failed to update food item: " . mysqli_error($con);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HomeBites | Edit Food Item</title>
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
        .current-image {
            max-width: 150px;
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
                <a class="nav-link" href="admin-dashboard.php#food">
                    <i class="fas fa-arrow-left"></i> Back to Food Items
                </a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="mb-4">Edit Food Item</h2>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="foodname">Food Name</label>
                <input type="text" class="form-control" id="foodname" name="foodname" value="<?php echo $food['foodname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="cost">Price</label>
                <input type="number" class="form-control" id="cost" name="cost" value="<?php echo $food['cost']; ?>" required>
            </div>
            <div class="form-group">
                <label for="cuisines">Cuisines</label>
                <input type="text" class="form-control" id="cuisines" name="cuisines" value="<?php echo $food['cuisines']; ?>" required>
            </div>
            <div class="form-group">
                <label for="paymentmode">Food Type</label>
                <select class="form-control" id="paymentmode" name="paymentmode" required>
                    <option value="Veg" <?php if($food['paymentmode'] == 'Veg') echo 'selected'; ?>>Vegetarian</option>
                    <option value="Non-Veg" <?php if($food['paymentmode'] == 'Non-Veg') echo 'selected'; ?>>Non-Vegetarian</option>
                </select>
            </div>
            <div class="form-group">
                <label for="vendor_id">Restaurant</label>
                <select class="form-control" id="vendor_id" name="vendor_id" required>
                    <?php while($restaurant = mysqli_fetch_assoc($restaurants)): ?>
                        <option value="<?php echo $restaurant['fldvendor_id']; ?>" <?php if($food['fldvendor_id'] == $restaurant['fldvendor_id']) echo 'selected'; ?>>
                            <?php echo $restaurant['fld_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Current Image</label><br>
                <img src="../image/restaurant/<?php echo $food['fld_email']; ?>/foodimages/<?php echo $food['fldimage']; ?>" class="current-image rounded">
            </div>
            <div class="form-group">
                <label for="food_pic">Change Image (Leave blank to keep current image)</label>
                <input type="file" class="form-control-file" id="food_pic" name="food_pic">
            </div>
            <button type="submit" class="btn btn-primary">Update Food Item</button>
            <a href="admin-dashboard.php#food" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

