<?php
session_start();
include("../connection.php");

if(!isset($_SESSION['admin_id'])) {
    header("location:admin-login.php?msg=Please Login To Access Admin Dashboard");
    exit();
}

// Get counts for dashboard
$vendor_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblvendor"));
$customer_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblcustomer"));
$food_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tbfood"));
$order_count = mysqli_num_rows(mysqli_query($con, "SELECT * FROM tblorder"));

// Handle logout
if(isset($_POST['logout'])) {
    session_destroy();
    header("location:admin-login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HomeBites | Admin Dashboard</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 56px;
        }
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #343a40;
            color: #fff;
        }
        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: calc(100vh - 56px);
            padding-top: 1rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, .75);
            padding: 1rem;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255, 255, 255, .1);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, .2);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        main {
            padding: 2rem;
        }
        .card-counter {
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
            padding: 20px 10px;
            background-color: #fff;
            height: 120px;
            border-radius: 5px;
            transition: .3s linear all;
        }
        .card-counter:hover {
            box-shadow: 0 8px 16px rgba(0,0,0,.2);
            transform: translateY(-3px);
        }
        .card-counter i {
            font-size: 4em;
            opacity: 0.3;
        }
        .card-counter .count-numbers {
            position: absolute;
            right: 35px;
            top: 20px;
            font-size: 32px;
            display: block;
        }
        .card-counter .count-name {
            position: absolute;
            right: 35px;
            top: 65px;
            font-style: italic;
            text-transform: capitalize;
            opacity: 0.7;
            display: block;
            font-size: 18px;
        }
        .card-counter.primary {
            background-color: #007bff;
            color: #FFF;
        }
        .card-counter.danger {
            background-color: #ef5350;
            color: #FFF;
        }
        .card-counter.success {
            background-color: #66bb6a;
            color: #FFF;
        }
        .card-counter.info {
            background-color: #26c6da;
            color: #FFF;
        }
        .tab-content {
            background: white;
            padding: 20px;
            border-radius: 0 0 5px 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,.1);
        }
        .nav-tabs {
            border-bottom: none;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #495057;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            color: #007bff;
            background-color: white;
            border-radius: 5px 5px 0 0;
            border: none;
            border-bottom: 3px solid #007bff;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">
            <i class="fas fa-utensils"></i> HomeBites Admin
        </a>
        <ul class="navbar-nav px-3 ml-auto">
            <li class="nav-item text-nowrap">
                <form method="post">
                    <button type="submit" name="logout" class="btn btn-link nav-link">
                        <i class="fas fa-sign-out-alt"></i> Sign out
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#dashboard" data-toggle="tab">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#users" data-toggle="tab">
                                <i class="fas fa-users"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#restaurants" data-toggle="tab">
                                <i class="fas fa-store"></i> Restaurants
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#food" data-toggle="tab">
                                <i class="fas fa-hamburger"></i> Food Items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#orders" data-toggle="tab">
                                <i class="fas fa-shopping-cart"></i> Orders
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="tab-content" id="myTabContent">
                    <!-- Dashboard Tab -->
                    <div class="tab-pane fade show active" id="dashboard" role="tabpanel">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Dashboard</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <div class="btn-group mr-2">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-calendar-alt"></i> Today
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card-counter primary">
                                    <i class="fas fa-users"></i>
                                    <span class="count-numbers"><?php echo $customer_count; ?></span>
                                    <span class="count-name">Users</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card-counter danger">
                                    <i class="fas fa-store"></i>
                                    <span class="count-numbers"><?php echo $vendor_count; ?></span>
                                    <span class="count-name">Restaurants</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card-counter success">
                                    <i class="fas fa-hamburger"></i>
                                    <span class="count-numbers"><?php echo $food_count; ?></span>
                                    <span class="count-name">Food Items</span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card-counter info">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="count-numbers"><?php echo $order_count; ?></span>
                                    <span class="count-name">Orders</span>
                                </div>
                            </div>
                        </div>

                        <h4>Recent Activity</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Restaurant</th>
                                        <th>Food Item</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $recent_orders = mysqli_query($con, "SELECT o.fld_order_id, c.fld_name as customer_name, v.fld_name as vendor_name, 
                                                                        f.foodname, o.fldstatus, o.fld_payment 
                                                                        FROM tblorder o 
                                                                        JOIN tblcustomer c ON o.fld_email_id = c.fld_email 
                                                                        JOIN tbfood f ON o.fld_food_id = f.food_id 
                                                                        JOIN tblvendor v ON o.fldvendor_id = v.fldvendor_id 
                                                                        ORDER BY o.fld_order_id DESC LIMIT 5");
                                    
                                    if(mysqli_num_rows($recent_orders) > 0) {
                                        while($row = mysqli_fetch_assoc($recent_orders)) {
                                            echo "<tr>";
                                            echo "<td>#" . $row['fld_order_id'] . "</td>";
                                            echo "<td>" . $row['customer_name'] . "</td>";
                                            echo "<td>" . $row['vendor_name'] . "</td>";
                                            echo "<td>" . $row['foodname'] . "</td>";
                                            
                                            // Status with color coding
                                            $status_class = '';
                                            switch($row['fldstatus']) {
                                                case 'Delivered':
                                                    $status_class = 'text-success';
                                                    break;
                                                case 'Out Of Stock':
                                                    $status_class = 'text-danger';
                                                    break;
                                                case 'cancelled':
                                                    $status_class = 'text-warning';
                                                    break;
                                                default:
                                                    $status_class = 'text-primary';
                                            }
                                            
                                            echo "<td><span class='" . $status_class . "'>" . $row['fldstatus'] . "</span></td>";
                                            echo "<td>Today</td>"; // You can add actual date if available in your database
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No recent orders</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Users Tab -->
                    <div class="tab-pane fade" id="users" role="tabpanel">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">User Management</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addUserModal">
                                    <i class="fas fa-plus"></i> Add New User
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Preference</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $users = mysqli_query($con, "SELECT * FROM tblcustomer ORDER BY fld_cust_id DESC");
                                    
                                    if(mysqli_num_rows($users) > 0) {
                                        while($row = mysqli_fetch_assoc($users)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['fld_cust_id'] . "</td>";
                                            echo "<td>" . $row['fld_name'] . "</td>";
                                            echo "<td>" . $row['fld_email'] . "</td>";
                                            echo "<td>" . $row['fld_mobile'] . "</td>";
                                            echo "<td>" . $row['fld_preference'] . "</td>";
                                            echo "<td>
                                                <a href='edit-user.php?id=" . $row['fld_cust_id'] . "' class='btn btn-sm btn-info'><i class='fas fa-edit'></i></a>
                                                <a href='delete-user.php?id=" . $row['fld_cust_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'><i class='fas fa-trash'></i></a>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No users found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Restaurants Tab -->
                    <div class="tab-pane fade" id="restaurants" role="tabpanel">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Restaurant Management</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#addRestaurantModal">
                                    <i class="fas fa-plus"></i> Add New Restaurant
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $restaurants = mysqli_query($con, "SELECT * FROM tblvendor ORDER BY fldvendor_id DESC");
                                    
                                    if(mysqli_num_rows($restaurants) > 0) {
                                        while($row = mysqli_fetch_assoc($restaurants)) {
                                            $logo_path = "../image/restaurant/" . $row['fld_email'] . "/" . $row['fld_logo'];
                                            
                                            echo "<tr>";
                                            echo "<td>" . $row['fldvendor_id'] . "</td>";
                                            echo "<td><img src='" . $logo_path . "' width='50' height='50' class='rounded-circle'></td>";
                                            echo "<td>" . $row['fld_name'] . "</td>";
                                            echo "<td>" . $row['fld_email'] . "</td>";
                                            echo "<td>" . $row['fld_mob'] . "</td>";
                                            echo "<td>" . $row['fld_address'] . "</td>";
                                            echo "<td>
                                                <a href='edit-restaurant.php?id=" . $row['fldvendor_id'] . "' class='btn btn-sm btn-info'><i class='fas fa-edit'></i></a>
                                                <a href='delete-restaurant.php?id=" . $row['fldvendor_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this restaurant?\")'><i class='fas fa-trash'></i></a>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>No restaurants found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Food Items Tab -->
                    <div class="tab-pane fade" id="food" role="tabpanel">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Food Item Management</h1>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Restaurant</th>
                                        <th>Price</th>
                                        <th>Cuisine</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $food_items = mysqli_query($con, "SELECT f.*, v.fld_name as vendor_name, v.fld_email 
                                                                    FROM tbfood f 
                                                                    JOIN tblvendor v ON f.fldvendor_id = v.fldvendor_id 
                                                                    ORDER BY f.food_id DESC");
                                    
                                    if(mysqli_num_rows($food_items) > 0) {
                                        while($row = mysqli_fetch_assoc($food_items)) {
                                            $food_pic = "../image/restaurant/" . $row['fld_email'] . "/foodimages/" . $row['fldimage'];
                                            
                                            echo "<tr>";
                                            echo "<td>" . $row['food_id'] . "</td>";
                                            echo "<td><img src='" . $food_pic . "' width='50' height='50' class='rounded'></td>";
                                            echo "<td>" . $row['foodname'] . "</td>";
                                            echo "<td>" . $row['vendor_name'] . "</td>";
                                            echo "<td>₹" . $row['cost'] . "</td>";
                                            echo "<td>" . $row['cuisines'] . "</td>";
                                            
                                            // Food type with icon
                                            if($row['paymentmode'] == "Veg") {
                                                echo "<td><span class='text-success'><i class='fas fa-leaf'></i> Veg</span></td>";
                                            } else {
                                                echo "<td><span class='text-danger'><i class='fas fa-drumstick-bite'></i> Non-Veg</span></td>";
                                            }
                                            
                                            echo "<td>
                                                <a href='edit-food.php?id=" . $row['food_id'] . "' class='btn btn-sm btn-info'><i class='fas fa-edit'></i></a>
                                                <a href='delete-food.php?id=" . $row['food_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this food item?\")'><i class='fas fa-trash'></i></a>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center'>No food items found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Orders Tab -->
                    <div class="tab-pane fade" id="orders" role="tabpanel">
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="h2">Order Management</h1>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Restaurant</th>
                                        <th>Food Item</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $orders = mysqli_query($con, "SELECT o.*, c.fld_name as customer_name, v.fld_name as vendor_name, 
                                                                f.foodname, f.cost 
                                                                FROM tblorder o 
                                                                JOIN tblcustomer c ON o.fld_email_id = c.fld_email 
                                                                JOIN tbfood f ON o.fld_food_id = f.food_id 
                                                                JOIN tblvendor v ON o.fldvendor_id = v.fldvendor_id 
                                                                ORDER BY o.fld_order_id DESC");
                                    
                                    if(mysqli_num_rows($orders) > 0) {
                                        while($row = mysqli_fetch_assoc($orders)) {
                                            echo "<tr>";
                                            echo "<td>#" . $row['fld_order_id'] . "</td>";
                                            echo "<td>" . $row['customer_name'] . "</td>";
                                            echo "<td>" . $row['vendor_name'] . "</td>";
                                            echo "<td>" . $row['foodname'] . "</td>";
                                            echo "<td>₹" . $row['cost'] . "</td>";
                                            
                                            // Status with color coding
                                            $status_class = '';
                                            switch($row['fldstatus']) {
                                                case 'Delivered':
                                                    $status_class = 'badge badge-success';
                                                    break;
                                                case 'Out Of Stock':
                                                    $status_class = 'badge badge-danger';
                                                    break;
                                                case 'cancelled':
                                                    $status_class = 'badge badge-warning';
                                                    break;
                                                default:
                                                    $status_class = 'badge badge-primary';
                                            }
                                            
                                            echo "<td><span class='" . $status_class . "'>" . $row['fldstatus'] . "</span></td>";
                                            echo "<td>
                                                <a href='edit-order.php?id=" . $row['fld_order_id'] . "' class='btn btn-sm btn-info'><i class='fas fa-edit'></i></a>
                                                <a href='delete-order.php?id=" . $row['fld_order_id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this order?\")'><i class='fas fa-trash'></i></a>
                                            </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='7' class='text-center'>No orders found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add-user.php" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" pattern="[7-9]{1}[0-9]{9}" required>
                        </div>
                        <div class="form-group">
                            <label for="preference">Preference</label>
                            <select class="form-control" id="preference" name="preference" required>
                                <option value="Veg">Vegetarian</option>
                                <option value="Non-Veg">Non-Vegetarian</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Restaurant Modal -->
    <div class="modal fade" id="addRestaurantModal" tabindex="-1" role="dialog" aria-labelledby="addRestaurantModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRestaurantModalLabel">Add New Restaurant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add-restaurant.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="r_name">Restaurant Name</label>
                            <input type="text" class="form-control" id="r_name" name="r_name" required>
                        </div>
                        <div class="form-group">
                            <label for="r_email">Email</label>
                            <input type="email" class="form-control" id="r_email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="r_password">Password</label>
                            <input type="password" class="form-control" id="r_password" name="pswd" required>
                        </div>
                        <div class="form-group">
                            <label for="r_mobile">Mobile</label>
                            <input type="tel" class="form-control" id="r_mobile" name="mob" pattern="[7-9]{1}[0-9]{9}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="logo">Restaurant Logo</label>
                            <input type="file" class="form-control-file" id="logo" name="logo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Restaurant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        // Activate tab based on URL hash
        $(document).ready(function() {
            if (window.location.hash) {
                $('.nav-link[href="' + window.location.hash + '"]').tab('show');
            }
            
            // Change URL hash when tab changes
            $('.nav-link').on('click', function() {
                window.location.hash = $(this).attr('href');
            });
        });
    </script>
</body>
</html>

