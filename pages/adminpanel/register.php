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
$tempPersonalInfo = array(
    "", "", "", "", "", "", "", "",
);
$postList = array(
    "fname",
    "mname",
    "lname",
    "bdate",
    "sex",
    "mnumber",
    "address",
    "course"
);
if (isset($_POST['register'])) {

    $personalInfo = new PersonalInformation();
    foreach ($postList as $key => $data) {
        $tempPersonalInfo[$key] = $_POST[$data];
    }
    $_SESSION['personalinfo'] = $tempPersonalInfo;
    header("Location: register_accountinfo.php");
}
if(isset($_GET['mode'])){
    $_SESSION['mode'] = 1;
}else{
    if(isset($_SESSION['mode'])){
        unset($_SESSION['mode']);
    }
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
            <form action="" method="POST">
                <h4 class="page-title"><?php echo isset($_SESSION['mode']) ? "Moderator": "Writers" ?> Personal Information<br>1/2</h4>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Firstname:</label>
                                <input style="" required type="text" class="form-control" value="<?php echo $tempPersonalInfo[0] ?>" name="fname">
                            </div>
                            <div class="form-group">
                                <label for="">Middlename:</label>
                                <input style="" required type="text" class="form-control" value="<?php echo $tempPersonalInfo[1] ?>" name="mname">
                            </div>
                            <div class="form-group">
                                <label for="">Lastname:</label>
                                <input style="" required type="text" class="form-control" value="<?php echo $tempPersonalInfo[2] ?>" name="lname">
                            </div>
                            <div class="form-group">
                                <label for="">Birthdate:</label>
                                <input style="" required type="date" class="form-control" value="<?php echo $tempPersonalInfo[3] ?>" name="bdate">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Sex:</label>
                                <select class="form-control" name="sex" style="margin: 4px 0;">
                                    <option <?php echo $tempPersonalInfo[4] == "" ?  "selected" : "" ?>></option>
                                    <option <?php echo $tempPersonalInfo[4] == "Male" ?  "selected" : "" ?>>Male</option>
                                    <option <?php echo $tempPersonalInfo[4] == "Female" ?  "selected" : "" ?>>Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Mobile number:</label>
                                <input style="" required type="text" class="form-control" value="<?php echo $tempPersonalInfo[5] ?>" name="mnumber">
                            </div>
                            <div class="form-group">
                                <label for="">Address:</label>
                                <input style="" required type="text" class="form-control" value="<?php echo $tempPersonalInfo[6] ?>" name="address">
                            </div>
                            <div class="form-group">
                                <label for="">Course:</label>
                                <select style="margin-top: 6px;" name="course" id="course" class="form-control" required>
                                    <option value="" hidden>Select Course</option>
                                    <option value="BS Information Technology">BS Information Technology</option>
                                    <option value="BS Architecture">BS Architecture</option>
                                    <option value="Civil Engineering">Civil Engineering</option>
                                    <option value="Mechanical Engineering">Mechanical Engineering</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-success" name="register" type="submit">Next</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>