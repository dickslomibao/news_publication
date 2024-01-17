<?php
require_once "../../classes/login_class.php";

$error = "";

if (isset($_POST['signup'])) {
    session_start();
    $_SESSION['userinfo'] = array(
        $_POST['fname'],
        "",
        $_POST['lname'],
        "",
        $_POST['sex'],
        "",
        "",
        $_POST['course'],
    );
    header("Location: register2.0.php");
    
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
                <h4 class="page-title">Sign up<br>1/2</h4>
                <div class="form-group">
                    <label for="">Firstname:</label>
                    <input type="text" class="form-control" id="" name="fname" placeholder="Firstname..." required>
                </div>
                <div class="form-group">
                    <label for="">Lastname:</label>
                    <input type="texr" class="form-control" id="" name="lname" placeholder="Lastname..."  required>
                </div>
                <div class="form-group">
                    <label for="">Sex:</label>
                    <select name="sex" id="" class="form-control" required>
                        <option value="" hidden>Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">Course:</label>
                    <select name="course" id="" class="form-control" required>
                        <option value="" hidden>Select Course</option>
                        <option value="BS Information Technology">BS Information Technology</option>
                        <option value="BS Architecture">BS Architecture</option>
                        <option value="Civil Engineering">Civil Engineering</option>
                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                    </select>
                </div>
                <?php if ($error != "") {
                    echo "<p class='error'>$error</p>";
                } ?>
                <button class="btn btn-success" name="signup" type="submit">Next</button>
                <center>
                    <a href="login.php">Already have an account?</a>
                </center>
           </form>

        </div>
    </div>
</body>

</html>