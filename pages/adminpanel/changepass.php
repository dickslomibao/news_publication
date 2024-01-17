<?php
require_once "../../classes/login_class.php";
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
require_once 'validate_viewer.php';
$error = "";
if (isset($_POST['change'])) {
    $auth = new Login;
    if ($_POST['password'] === $_POST['repassword']) {
        $auth->setUsername($_SESSION['username']);
        $auth->setPassword(md5($_POST['password']));
        $auth->changePass();
        $_SESSION['password'] = md5($_POST['password']);
        header("Location: dashboard.php");
    } else {
        $error = "Password didn't match";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change password</title>
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
        <div class="login-container">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-4 login-content">
                        <form action="" method="post">
                            <h4 class="page-title">Change password</h4>
                            <div class="form-group">
                                <label for="">New password:</label>
                                <input type="password" class="form-control" id="" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="">Re-type new password:</label>
                                <input type="Password" class="form-control" id="" name="repassword" required>
                            </div>
                            <?php if ($error != "") {
                                echo "<p class='error'>$error</p>";
                            } ?>
                            <button class="btn btn-success" name="change" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>