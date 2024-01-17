<?php
require_once "../../classes/login_class.php";
session_start();
$error = "";
if(isset($_SESSION['username'])){
    header('Location: ../../');
}
if (isset($_POST['signin'])) {
    
    $auth = new Login;
    $auth->setUsername($_POST['uname']);
    $result = $auth->validateFirstTime();
    if (count($result) >= 1) {
        $isFirstTime = false;
        if (strval($result[0]['status']) === "0") {
            $auth->setPassword($_POST['password']);
            $isFirstTime = true;
        } else {
            $auth->setPassword(md5($_POST['password']));
        }
        if (count($auth->authenticate()) >= 1) {
            $userdata = $auth->authenticate();
            $_SESSION['role'] = strval($userdata[0]['role']);
            $_SESSION['id'] = strval($userdata[0]['owner_id']);
            $_SESSION['username'] = $_POST['uname'];
            $_SESSION['password'] = md5($_POST['password']);
            $_SESSION['validator'] = strval($userdata[0]['validator']);
            if (strval($userdata[0]['role']) === '2') {
                if(isset($_GET['redirect'])){
                    header("Location: ".urldecode($_GET['redirect']));
                }else{
                    header("Location: ../../");
                }
                
            } else {
                if ($isFirstTime) {
                    $_SESSION['password'] = $_POST['password'];
                    header("Location: ../adminpanel/changepass.php");
                } else {
                    $_SESSION['password'] = md5($_POST['password']);
                    header("Location: ../adminpanel/dashboard.php");
                }
            }
        }
    }
    $error = "Invalid account.";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link href="../../css/body_configuration.css" rel="stylesheet">
    <link href="../../css/navbar.css" rel="stylesheet">
    <link href="../../css/login.css" rel="stylesheet">
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">

</head>

<body>

    <div class="margin-side">
        <div class="login-content">
            <form action="" method="post">
                <h1 class="logo">GA<span>ZSE</span>NT</h1>
                <h4 class="page-title">Sign in</h4>
                <div class="form-group">
                    <label for="">Username:</label>
                    <input type="text" class="form-control" id="" name="uname" required>
                </div>
                <div class="form-group">
                    <label for="">Password:</label>
                    <input type="Password" class="form-control" id="" name="password" required>
                </div>
                <?php if ($error != "") {
                    echo "<p class='error'>$error</p>";
                } ?>
                <button class="btn btn-success" name="signin" type="submit">Sign in</button>
                <center>
                    <a href="../site/register1.0.php">Create an account</a>
                </center>
            </form>
        </div>

    </div>
</body>

</html>