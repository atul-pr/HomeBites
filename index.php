<?php
session_start();

include("connection.php");
extract($_REQUEST);
$arr = array();

if (isset($_GET['msg'])) {
    $loginmsg = $_GET['msg'];
} else {
    $loginmsg = "";
}

if (isset($_SESSION['cust_id'])) {
    $cust_id = $_SESSION['cust_id'];
    $cquery = mysqli_query($con, "SELECT * FROM tblcustomer WHERE fld_email='$cust_id'");
    $cresult = mysqli_fetch_array($cquery);
} else {
    $cust_id = "";
}

if (!empty($_SESSION['cust_id'])) {
    $fetch = mysqli_query($con, "SELECT fld_preference FROM tblcustomer WHERE fld_email='$cust_id'");
    $pfetch = mysqli_fetch_array($fetch);
    $pref = $pfetch['fld_preference'];
} else {
    $pref = 1;
}

if (isset($addtocart)) {
    if (!empty($_SESSION['cust_id'])) {
        header("location:form/cart.php?product=$addtocart");
    } else {
        header("location:form/?product=$addtocart");
    }
}

$query = mysqli_query($con, "SELECT tbfood.foodname, tbfood.fldvendor_id, tbfood.cost, tbfood.cuisines, tbfood.fldimage, tblcart.fld_cart_id, 
    tblcart.fld_product_id, tblcart.fld_customer_id FROM tbfood INNER JOIN tblcart ON tbfood.food_id=tblcart.fld_product_id WHERE 
    tblcart.fld_customer_id='$cust_id'");
$re = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>HomeBites | Home</title>

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>

    <!-- Inline CSS for Hover Effect -->
    <style>
        .navbar-custom {
            background: rgba(0, 0, 0, 0.7) !important; /* Black with 70% opacity */
        }

        /* Hover Effect for Menu Cards */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05); /* Slightly enlarge the card */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Add a deeper shadow */
        }
        .card-img-top {
            width: 100%;
            height: 150px;
            object-fit: cover; /* Ensure images fit nicely */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="index.php">
                <i class="fas fa-utensils"></i> HomeBites
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample07">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <?php if (!empty($cust_id)) { ?>
                            <a class="navbar-brand" style="color:#1fafdb; text-decoration:none;">
                                <i class="far fa-user"></i> Hi! <?php echo $cresult['fld_name']; ?>
                            </a>
                        <?php } ?>
                    </li>
                    <?php if (empty($cust_id)) { ?>
                        <li class="nav-item">
                            <a href="form/index.php?msg=User must be logged in">
                                <span style="color:red; font-size:25px;">
                                    <i class="fa fa-shopping-cart" aria-hidden="true">
                                        <span style="color:red;" id="cart" class="badge badge-light">0</span>
                                    </i>
                                </span>
                            </a>
                            <a href="form/index.php"><button class="btn btn-info my-2 my-sm-0" name="login" type="submit">Log In</button></a>
                            <a href="form/userSignUp.php"><button class="btn btn-primary my-2 my-sm-0" type="submit">Register</button></a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a href="form/cart.php">
                                <span style="color:green; font-size:20px;">
                                    <i class="fa fa-shopping-cart" aria-hidden="true">
                                        <span style="color:green;" id="cart" class="badge badge-light"><?php if (isset($re)) { echo $re; } ?></span>
                                    </i>
                                </span>
                            </a>
                            <a href="logout.php"><button class="btn btn-success my-2 my-sm-0" type="submit">Log Out</button></a>
                        </li>
                    <?php } ?>
                </ul>
                <form class="form-inline my-2 my-md-0">
                    <a href="sellerSignUp.php"><button type="button" class="btn btn-lg btn-block btn-warning">HomeBites Business <i class="fas fa-arrow-circle-right"></i></button></a>
                </form>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container">
        <main role="main">
            <div class="jumbotron" style="background: url(assets/images/foodthumb5.jpg) no-repeat center / cover;">
                <div class="col-sm-8 mx-auto">
                    <h3 style="color: white;">Gᴇᴛ Tᴀꜱᴛʏ Hᴏᴍᴇᴍᴀᴅᴇ Fᴏᴏᴅ Lɪᴋᴇ Hᴏᴍᴇ Oɴʟʏ Oɴ Hᴏᴍʙɪᴛᴇꜱ.</h3>
                    <p style="color: white;">𝕄𝕠𝕤𝕥 𝕀𝕟𝕥𝕖𝕣𝕖𝕤𝕥𝕚𝕟𝕘 𝔽𝕠𝕠𝕕 𝕋𝕠 𝕐𝕠𝕦𝕣 𝔻𝕠𝕠𝕣𝕤𝕥𝕖𝕡..</p>
                    <p style="color: white;">𝕆𝕣𝕕𝕖𝕣 𝕗𝕠𝕠𝕕 𝕗𝕣𝕠𝕞 𝕗𝕒𝕧𝕠𝕦𝕣𝕚𝕥𝕖 𝕂𝕚𝕥𝕔𝕙𝕖𝕟 𝕟𝕖𝕒𝕣 𝕪𝕠𝕦.</p>
                </div>
            </div>
        </main>
    </div>

    <!-- Menu Section with Hover Effect -->
    <div class="album py-5 bg-light">
        <div class="container">
            <h3 class="pb-3 mb-4 border-bottom">Choose From Most Popular</h3>
            <div class="row">
                <?php
                if ($pref == 1) {
                    $query = mysqli_query($con, "SELECT tbfood.food_id, tblvendor.fld_name, tbfood.foodname, tbfood.cost, tbfood.cuisines, tbfood.fldimage, tbfood.paymentmode, tblvendor.fld_email, tblvendor.fld_logo 
                        FROM tbfood INNER JOIN tblvendor ON tbfood.fldvendor_id=tblvendor.fldvendor_id ORDER BY food_id DESC");
                } elseif ($pref == "Veg") {
                    $query = mysqli_query($con, "SELECT tbfood.food_id, tblvendor.fld_name, tbfood.foodname, tbfood.cost, tbfood.cuisines, tbfood.fldimage, tbfood.paymentmode, tblvendor.fld_email, tblvendor.fld_logo 
                        FROM tbfood INNER JOIN tblvendor ON tbfood.fldvendor_id=tblvendor.fldvendor_id AND paymentmode='Veg' ORDER BY food_id DESC");
                } else {
                    $query = mysqli_query($con, "SELECT tbfood.food_id, tblvendor.fld_name, tbfood.foodname, tbfood.cost, tbfood.cuisines, tbfood.fldimage, tbfood.paymentmode, tblvendor.fld_email, tblvendor.fld_logo 
                        FROM tbfood INNER JOIN tblvendor ON tbfood.fldvendor_id=tblvendor.fldvendor_id AND paymentmode='Non-Veg' ORDER BY food_id DESC");
                }
                while ($res = mysqli_fetch_array($query)) {
                    $hotel_logo = "image/restaurant/" . $res['fld_email'] . "/" . $res['fld_logo'];
                    $food_pic = "image/restaurant/" . $res['fld_email'] . "/foodimages/" . $res['fldimage'];
                ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top" src="<?php echo $food_pic; ?>" alt="<?php echo $res['foodname']; ?>">
                            <div class="card-body">
                                <p class="card-text">
                                    <img class="rounded-circle" src="<?php echo $hotel_logo; ?>" alt="<?php echo $res['fld_name']; ?>" width="30px" height="auto"> 
                                    <?php echo $res['fld_name']; ?> <br><br>
                                    <i class="fas fa-utensils"></i> <b><?php echo $res['foodname']; ?></b> <br>
                                    Cuisine: <?php echo $res['cuisines']; ?> <br>
                                    <i class="fas fa-rupee-sign"></i>. <b><?php echo $res['cost']; ?></b> Only
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <form method="post">
                                            <button type="submit" class="btn btn-sm btn-success" name="addtocart" value="<?php echo $res['food_id']; ?>">Order Now!</button>
                                        </form>
                                    </div>
                                    <small class="text-muted">
                                        <?php if ($res['paymentmode'] == "Veg") { ?>
                                            <img src="assets/images/veg.png">
                                        <?php } else { ?>
                                            <img src="assets/images/nonveg.png">
                                        <?php } ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

   <!-- Footer -->
<footer class="container">
    <p><center>
        &copy; 2025 HomeBites. All rights reserved. |
        <a href="#">Back to top</a> |
    </center></p>
    <p><center>
        Follow us on:
        <a href="https://twitter.com/atulxz" target="_blank"><i class="fab fa-twitter"></i></a>
        <a href="https://github.com/atul-pr" target="_blank"><i class="fab fa-github"></i></a>
        <a href="https://instagram.com/atulxz" target="_blank"><i class="fab fa-instagram"></i></a>
    </center></p>    
</footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>