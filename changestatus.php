<?php 
include("connection.php");
session_start();
extract($_REQUEST);
if(isset($updstatus))
{
    if(!empty($_SESSION['id']))
    {
        if(mysqli_query($con,"UPDATE tblorder SET fldstatus='$status' WHERE fld_order_id='$order_id'"))
        {
            header("location:dashboard.php");
        }
    }
    else
    {
        header("location:sellerSignIn.php?msg=You Must Login First");
    }
}
if(isset($logout))
{
    session_destroy();
    header("location:sellerSignIn.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HomeBites</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: rgba(0, 0, 0, 0.8);
        }
        .container-box {
            max-width: 500px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fas fa-utensils"></i> HomeBites || Status</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <?php if(!empty($id)) { ?>
                        <span class="navbar-text text-white"><i class="far fa-user"></i> Welcome, <?php echo $vr['fld_name']; ?></span>
                    <?php } ?>
                </li>
            </ul>
            <form class="form-inline my-2 my-md-0">
                <?php if(empty($_SESSION['id'])) { ?>
                    <button class="btn btn-outline-light my-2 my-sm-0" name="login"><i class="fas fa-sign-in-alt"></i> Log In</button>
                <?php } else { ?>
                    <button class="btn btn-outline-danger my-2 my-sm-0" name="logout" type="submit"><i class="fas fa-sign-out-alt"></i> Log Out</button>
                <?php } ?>
            </form>
        </div>
    </div>
</nav>
<div class="container d-flex justify-content-center">
    <div class="container-box">
        <h3 class="text-center text-danger border-bottom pb-3">Update Order Status</h3>
        <div class="text-center text-danger"><?php if(isset($admin_login_error)) echo $admin_login_error; ?></div>
        <form method="post">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="Delivered" id="delivered">
                    <label class="form-check-label" for="delivered">Delivered</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="Out Of Stock" id="outOfStock">
                    <label class="form-check-label" for="outOfStock">Out Of Stock</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" value="Cancelled" id="cancelled">
                    <label class="form-check-label" for="cancelled">Cancelled</label>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-block" name="updstatus">Update Status</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>