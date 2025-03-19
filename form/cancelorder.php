<?php
include("../connection.php");

if($id=$_GET['id'])
	
	{
		if(mysqli_query($con,"update tblorder set fldstatus='cancelled' where fld_order_id='$id'"))
		{
			 header( "refresh:2;url=cart.php" );
		}
	}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HomeBites</title>

    <link rel="canonical" href="index.html">

    <!-- Bootstrap -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>
<style>
  h1 {
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
}
p {
  text-align: center;
  font-size: 60px;
  margin-top: 0px;
}
  </style>

</head>
<body>
<style>
    /* Light dark transparent navbar */
    .navbar {
        background: rgba(0, 0, 0, 0.6) !important; /* Light dark transparency */
        backdrop-filter: blur(5px); /* Soft blur effect */
        transition: all 0.3s ease-in-out;
    }

    .navbar-brand {
        font-weight: bold;
        font-size: 24px;
        color: #fff !important;
    }

    .navbar-toggler {
        border: none;
    }

    .navbar-toggler:focus, .navbar-toggler:active {
        outline: none;
        box-shadow: none;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">HomeBites</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07"
            aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container" style="margin:0px auto;text-align:center;">
     <p style="color:green;">Cancelling Your Order<br>Please Wait</p>
	 <img src="../assets/images/cancel3.gif"/></div>
	   <h1><time>00</time></h1>
<script>
var h1 = document.getElementsByTagName('h1')[0],
    start = document.getElementById('start'),
    stop = document.getElementById('stop'),
    clear = document.getElementById('clear'),
    seconds = 0, minutes = 0, hours = 0,
    t;

function add() {
    seconds++;
    if (seconds >= 60) {
        seconds = 0;
        minutes++;
        if (minutes >= 60) {
            minutes = 0;
            hours++;
        }
    }
    
    h1.textContent =   (seconds > 9 ? seconds : "0" + seconds);

    timer();
}
function timer() {
    t = setTimeout(add, 1000);
}
timer();



</script>

</body>
</html>
