<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
if($_SESSION['role'] !== '5'){
    header("Location: dashboard.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/body_configuration.css">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">

    <style>
        body {
            overflow: hidden;
            background-color: #002366;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        a{
            color: white;
            text-decoration: none;
            padding: 5px 20px;
            border-radius: 10px;
            border:1px solid white;
        }
    </style>
</head>

<body>
    <div>
        <center>
            <h2>You are restricted</h2>
            <br>
            <a href="logout.php">Sign out</a>
            <a href="../../">Browse</a>
        </center>
    </div>

</body>

</html>