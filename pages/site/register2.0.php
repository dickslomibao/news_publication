<?php
require_once "../../classes/user_personal_info.php";
require_once "../../classes/user_account_info.php";
$error = "";
$success = false;
session_start();
if (!isset($_SESSION['userinfo'])) {
    header("Location: register1.0.php");
}
if(isset($_POST['signin'])){
    if($_POST['password'] != $_POST['repassword']){
        $error = "Password didn't match.";
    }else{
       try {
        $user = new PersonalInformation();
        $account = new AccountInformation();

        $id = uniqid().time();
        $user->initialize($_SESSION['userinfo']);
        $user->setId($id);
        $user->insert();
        $account->initialize([
            $_POST['uname'],
            $_POST['email'],
            md5($_POST['password']),
        ]);
        $account->setOwnerid($id);
        $account->setProfilePic("");
        $account->setStatus(1);
        $account->setRole(2);
        $account->insert();
        $success = true;
       } catch (PDOException $eh) {
        $error = "Something went wrong. ".$eh->getMessage();
       }
    }
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">

</head>

<body>
<?php if($success) {?>
    <script>
        swal("Success!", "Your account is created!", "success");
    </script>
    <?php header("Refresh: 3; url = login.php"); exit();}
    ?>
    <div class="margin-side">
        <div class="login-content">
            <form action="" method="post">
                <h1 class="logo">GA<span>ZSE</span>NT</h1>
                <h4 class="page-title">Sign up<br>2/2</h4>
                <div class="form-group">
                    <label for="">Username:</label>
                    <input type="text" class="form-control" id="" name="uname" required>
                </div>
                <div class="form-group">
                    <label for="">Email:</label>
                    <input type="email" class="form-control" id="" name="email" required>
                </div>
                <div class="form-group">
                    <label for="">Password:</label>
                    <input type="password" class="form-control" id="" name="password" required>
                </div>
                <div class="form-group">
                    <label for="">Re-type password:</label>
                    <input type="password" class="form-control" id="" name="repassword" required>
                </div>
                <?php if ($error != "") {
                    echo "<p class='error'>$error</p>";
                } ?>
                <button class="btn btn-success" name="signin" type="submit">Signup</button>
                <center>
                    <a href="login.php">Already have an account?</a>
                </center>
            </form>
        </div>
    </div>
</body>

</html>