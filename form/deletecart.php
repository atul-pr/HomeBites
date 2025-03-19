<?php
    header("refresh:3;url=cart.php");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HomeBites</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
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
        .container-box {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }
        h1 {
            font-size: 50px;
            font-weight: bold;
            color: #dc3545;
            margin: 10px 0;
        }
        p {
            font-size: 20px;
            color: #28a745;
            font-weight: bold;
        }
        .loading {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .timer-text {
            font-size: 30px;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>

    <div class="container-box">
        <p>Deleting Item from Cart...</p>
        <div class="loading"></div>
        <p>Please Wait</p>
        <h1 class="timer-text"><time>3</time></h1>
    </div>

    <script>
        var timeElement = document.getElementsByTagName('time')[0];
        var seconds = 3;

        function countdown() {
            seconds--;
            timeElement.textContent = seconds;
            if (seconds > 0) {
                setTimeout(countdown, 1000);
            }
        }

        countdown();
    </script>

</body>
</html>
