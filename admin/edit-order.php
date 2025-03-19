<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

if(!isset($_GET['id'])) {
    header("location:admin-dashboard.php#orders");
    exit();
}

$order_id = $_GET['id'];
$order_query = mysqli_query($con, "SELECT o.*, c.fld_name as customer_name, v.fld_name as vendor_name, 
                                  f.foodname, f.cost 
                                  FROM tblorder o 
                                  JOIN tblcustomer c ON o.fld_email_id = c.fld_email 
                                  JOIN tbfood f ON o.fld_food_id = f.food_id 
                                  JOIN tblvendor v ON o.fldvendor_id = v.fldvendor_id 
                                  WHERE o.fld_order_id='$order_id'");

if(mysqli_num_rows($order_query) == 0) {
    $_SESSION['error'] = "Order not found!";
    header("location:admin-dashboard.php#orders");
    exit();
}

$order = mysqli_fetch_assoc($order_query);

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    
    // Update order status
    $update_query = mysqli_query($con, "UPDATE tblorder SET fldstatus='$status' WHERE fld_order_id='$order_id'");
    
    if($update_query) {
        $_SESSION['success'] = "Order status updated successfully!";
        header("location:admin-dashboard.php#orders");
        exit();
    } else {
        $error = "Failed to update order status: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HomeBites | Edit Order</title>
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
        .order-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
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
                <a class="nav-link" href="admin-dashboard.php#orders">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </li>
        </ul>
    </nav>

    <div class="container">
        <h2 class="mb-4">Edit Order #<?php echo $order_id; ?></h2>
        
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="order-details">
            <h5>Order Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Customer:</strong> <?php echo $order['customer_name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $order['fld_email_id']; ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Restaurant:</strong> <?php echo $order['vendor_name']; ?></p>
                    <p><strong>Food Item:</strong> <?php echo $order['foodname']; ?></p>
                    <p><strong>Amount:</strong> ₹<?php echo $order['cost']; ?></p>
                </div>
            </div>
        </div>
        
        <form action="" method="post">
            <div class="form-group">
                <label for="status">Order Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Pending" <?php if($order['fldstatus'] == 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Delivered" <?php if($order['fldstatus'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                    <option value="Out Of Stock" <?php if($order['fldstatus'] == 'Out Of Stock') echo 'selected'; ?>>Out Of Stock</option>
                    <option value="cancelled" <?php if($order['fldstatus'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Order</button>
            <a href="admin-dashboard.php#orders" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

