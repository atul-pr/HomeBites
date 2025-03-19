<?php 
session_start();
include('connection.php');
$idd = $_GET['food_id'];
if (isset($_SESSION['id'])) {
    $q = mysqli_query($con, "SELECT tblvendor.fld_name, tbfood.fldimage, tblvendor.fldvendor_id, tblvendor.fld_email FROM tblvendor INNER JOIN tbfood ON tblvendor.fldvendor_id = tbfood.fldvendor_id WHERE tbfood.food_id = '$idd'");
    $res = mysqli_fetch_assoc($q);
    $e = $res['fld_email'];
    $img = $res['fldimage'];

    unlink("image/restaurant/$e/foodimages/$img");

    if (mysqli_query($con, "DELETE FROM tbfood WHERE food_id='$idd'")) {
        header("refresh:3;url=dashboard.php");
    } else {
        echo "Failed to delete";
    }
} else {
    header("location:vendor_login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Removing Item | HomeBites</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 200px;
        }
        h1 {
            font-size: 36px;
            margin: 10px 0;
            color: #343a40;
        }
        p {
            font-size: 18px;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <p><i class="fas fa-trash-alt"></i> Removing Item...</p>
        <h1 id="timer">3</h1>
    </div>

    <script>
        var timerElement = document.getElementById('timer');
        var seconds = 3;

        function updateTimer() {
            if (seconds > 0) {
                seconds--;
                timerElement.textContent = seconds;
            }
        }
        setInterval(updateTimer, 1000);
    </script>
</body>
</html>