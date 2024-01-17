<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
if ($_SESSION['role'] !== '1') {
    header("Location: dashboard.php");
    return;
}
?>
<?php
require_once "../../classes/user_personal_info.php";
require_once "../../classes/user_account_info.php";
$PERSONAL_INFO = new PersonalInformation();
$ACCOUNT_INFO = new AccountInformation();

$tempAccountInfo = array("", "", "", "");
$postList = array(
    "uname",
    "email",
    "password",
    "repass",
);
$error = "";

if (isset($_POST['submit'])) {
    foreach ($postList as $key => $value) {
        $tempAccountInfo[$key] = $_POST[$value];
    }
    //Validate if the password is match.
    if ($tempAccountInfo[2] === $tempAccountInfo[3]) {
        try {
            $extensionName =  pathinfo($_FILES['profilepic']['name'], PATHINFO_EXTENSION);
            $fullFileName = $_POST[$postList[0]] . uniqid() . "." . $extensionName;
            //validate if the profile pic is successfully uploaded.
            if (move_uploaded_file($_FILES['profilepic']['tmp_name'], "..\\..\\assets\\profilepic\\$fullFileName")) {
                $id = randomId();
                $tempPersonalInfo = $_SESSION['personalinfo'];
                //initialize and insert the personal info from 1/2
                $PERSONAL_INFO->setId($id);
                $PERSONAL_INFO->initialize($tempPersonalInfo);
                $PERSONAL_INFO->insert();
                //remove the last re-type-password
                array_pop($tempAccountInfo);
                //initialize and insert the account info from 2/2
                $ACCOUNT_INFO->setOwnerid($id);
                $ACCOUNT_INFO->setProfilePic($fullFileName);
                $ACCOUNT_INFO->initialize($tempAccountInfo);
                $ACCOUNT_INFO->setStatus(0);
                $ACCOUNT_INFO->setRole(0);
                $ACCOUNT_INFO->setValidator(isset($_SESSION['mode']) ? 1 : 0);
                $ACCOUNT_INFO->insert();

                header("Location: view_writers.php");
            }
        } catch (PDOException $ex) {
            $error = "There is something wrong " . $ex->getMessage();
        }
    } else {
        $error = "Password didn't match.";
    }
}
function randomId()
{
    return uniqid() . time();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
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
        <div class="login-content" style="max-width:600px;">
            <form action="" method="POST" enctype="multipart/form-data">

                <h4 class="page-title"><?php echo isset($_SESSION['mode']) ? "Moderator" : "Writers" ?> Account Credentials<br>2/2</h4>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Username:</label>
                                <input required type="text" class="form-control" value="<?php echo $tempAccountInfo[0]; ?>" name="uname">
                            </div>
                            <div class="form-group">
                                <label for="">Pasword:</label>
                                <input required type="password" class="form-control" value="<?php echo $tempAccountInfo[2]; ?>" name="password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email:</label>
                                <input required type="email" class="form-control" value="<?php echo $tempAccountInfo[1]; ?>" name="email">
                            </div>
                            <div class="form-group">
                                <label for="">Re-type password:</label>
                                <input required type="password" class="form-control" value="<?php echo $tempAccountInfo[3]; ?>" name="repass">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Profile Picture:</label>
                                <input required type="file" class="form-control" name="profilepic">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php if ($error != "") {
                                echo "<p class='error'>$error</p>";
                            } ?>
                            <button class="btn btn-success" name="submit" type="submit">Register</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>