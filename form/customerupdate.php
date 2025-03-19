<?php
    header("refresh:3;url=cart.php");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HomeBites</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/d8aeeb35ee.js" crossorigin="anonymous"></script>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            text-align: center;
        }

        /* Navbar */
        .navbar {
            background: rgba(0, 0, 0, 0.85) !important;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
        }

        /* Container */
        .message-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }

        p {
            font-size: 24px;
            color: green;
            font-weight: bold;
        }

        h1 {
            font-size: 50px;
            color: #dc3545;
            font-weight: bold;
            margin-top: 10px;
        }

        img {
            width: 100px;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-utensils"></i> HomeBites
        </a>
    </div>
</nav>

<!-- Message & Countdown -->
<div class="message-container">
    <p>Updating Your Details<br>Please Wait...</p>
    <img src="../assets/images/loading.gif" alt="Loading">
    <h1 id="countdown">03</h1>
</div>

<script>
    let seconds = 3;
    function countdown() {
        if (seconds > 0) {
            document.getElementById("countdown").textContent = seconds < 10 ? "0" + seconds : seconds;
            seconds--;
            setTimeout(countdown, 1000);
        }
    }
    countdown();
</script>

</body>
</html>
