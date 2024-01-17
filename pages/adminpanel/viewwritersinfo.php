<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    return;
}

if ($_SESSION['role'] !== '1') {
    header("Location: ../../");
    return;
}
if(!isset($_GET['id'])){
    header("Location: view_writers.php");
}

require_once '../../classes/user_personal_info.php';
require_once '../../classes/user_account_info.php';
$userClass = new PersonalInformation;
$accClass = new AccountInformation;

$personalInfo = $userClass->getUsersPersonalInfo($_GET['id']);
$accountInfo = $accClass->getUsersAccountINfo($_GET['id']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View writer info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,900;1,100;1,300;1,400;1,500;1,900&display=swap');
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link href="../../css/body_configuration.css" rel="stylesheet">
    <link href="../../css/navbar.css" rel="stylesheet">
    <link href="../../css/index.css" rel="stylesheet">

    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">
    <style>
        #others {
            overflow: auto;

        }

        #others::-webkit-scrollbar {
            display: none;
            /* Safari and Chrome */

        }

        #content-info {
            border: 1px solid rgba(0, 0, 0, .2);
            padding: 20px;
            border-radius: 10px;
        }

        .title-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .change-pass-btn,
        .change-pass-btn:hover {
            text-decoration: none;
            padding: 6px 20px;
            background-color: #002366;
            color: white;
            border-radius: 10px;
            font-size: 16px;
        }

        .btn-modify {
            margin-top: 20px;
            text-decoration: none;
            padding: 6px 20px;
            background-color: #002366;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            border: 0;
        }

        .modal-header {
            background-color: #002366;
            color: white;
        }

        label {
            margin: 5px 0;
        }

        p span {
            font-weight: 500;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <?php require_once "navbar.php" ?>
    <div class="margin-side" style="margin-top: 0;">
        <div class="container-fluid">
            <div class="row">
                <div class="title-row">
                    <h4 class="latest-header-title" style="margin: 40px 0;">
                        Writer information
                    </h4>
                </div>
            </div>
            <div class="row" id='content-info'>
                <div class="col-md-12">
                    <h5>Personal information</h5>
                    <br>
                    <p><span>Name:</span> <?php echo $personalInfo[0]['firstname'] . ' ' . $personalInfo[0]['middlename'] . ' ' . $personalInfo[0]['lastname']; ?></p>
                    <p><span>Sex:</span> <?php echo $personalInfo[0]['sex']; ?></p>
                    <p><span>Course:</span> <?php echo $personalInfo[0]['course']; ?></p>
                    <p><span>Birthdate:</span> <?php echo $personalInfo[0]['birthdate']; ?></p>
                    <p><span>Mobile number:</span> <?php echo $personalInfo[0]['mobilenumber']; ?></p>
                    <p><span>Address:</span> <?php echo $personalInfo[0]['address']; ?></p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <h5>Account Credentials</h5>
                        <br>
                       
                        <p><span>Username:</span> <?php echo $accountInfo[0]['username']; ?></p>
                        <?php if($accountInfo[0]['status'] === '0'){?>
                            <p><span>Password:</span> <?php echo $accountInfo[0]['password']; ?></p>
                        <?php }?>
                        <p><span>Email:</span> <?php echo $accountInfo[0]['email']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once 'footer.php' ?>
</body>

</html>