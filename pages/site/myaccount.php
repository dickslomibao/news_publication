<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    return;
}

if ($_SESSION['role'] === '5') {
    header("Location: ../adminpanel/restricted.php");
    return;
}

if ($_SESSION['role'] !== '2') {
    header("Location: ../adminpanel/dashboard.php");
    return;
}
require_once '../../classes/user_personal_info.php';
require_once '../../classes/user_account_info.php';
$userClass = new PersonalInformation;
$accClass = new AccountInformation;

$personalInfo = $userClass->getUsersPersonalInfo($_SESSION['id']);
$accountInfo = $accClass->getUsersAccountINfo($_SESSION['id']);

if (isset($_POST['updateaccount'])) {
    try {

        $accClass->userUpdate(
            array(
                $_POST['uname'],
                $_POST['email'],
                $_SESSION['id']
            )
        );
        $userClass->userUpdate(
            array(
                $_POST['fname'],
                $_POST['lname'],
                $_POST['sex'],
                $_POST['course'],
                $_SESSION['id']
            )
        );
        $_SESSION['username'] = $_POST['uname'];

        header('Location: myaccount.php');
    } catch (\Throwable $th) {
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My accoount</title>
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
            padding: 5px 20px;
            background-color: #002366;
            color: white;
            border-radius: 10px;
            font-size: 16px;
        }

        .btn-modify {
            margin-top: 20px;
            text-decoration: none;
            padding: 5px 20px;
            background-color: #002366;
            color: white;
            border-radius: 5px;
            font-size: 15px;
            border: 0;
        }

        .modal-header {
            background-color: #002366;
            color: white;
        }

        label {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <?php require_once "nav.php" ?>
    <div class="margin-side" style="margin-top: 0;">
        <div class="container-fluid">
            <div class="row">
                <div class="title-row">
                    <h4 class="latest-header-title" style="margin: 40px 0;">
                        My account
                    </h4>
                    <a href="changepass.php" class="change-pass-btn">
                        Change password
                    </a>
                </div>
            </div>
            <div class="row" id='content-info'>
                <div class="col-md-12">
                    <h5>Personal information</h5>
                    <br>
                    <p>Name: <?php echo $personalInfo[0]['firstname'] . ' ' . $personalInfo[0]['lastname']; ?></p>
                    <p>Sex: <?php echo $personalInfo[0]['sex']; ?></p>
                    <p>Course: <?php echo $personalInfo[0]['course']; ?></p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <h5>Account Credentials</h5>
                        <br>
                        <p>Username: <?php echo $accountInfo[0]['username']; ?></p>
                        <p>Email: <?php echo $accountInfo[0]['email']; ?></p>

                        <button class="btn-modify" data-bs-toggle="modal" data-bs-target="#exampleModal">Modify Information</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="exampleModalLabel">Your Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" style="padding:0 20px 10px 20px;">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Firstname:</label>
                                        <input value="<?php echo $personalInfo[0]['firstname']; ?>" type="text" class="form-control" id="" name="fname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Lastname:</label>
                                        <input value="<?php echo $personalInfo[0]['lastname']; ?>" type="texr" class="form-control" id="" name="lname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Sex:</label>
                                        <select name="sex" id="" class="form-control" required>
                                            <option value="" hidden>Select gender</option>
                                            <option value="Male" <?php echo $personalInfo[0]['sex'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                            <option value="Female" <?php echo $personalInfo[0]['sex'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Course:</label>
                                        <select name="course" id="course" class="form-control" required>
                                            <option value="" hidden>Select Course</option>
                                            <option value="BS Information Technology">BS Information Technology</option>
                                            <option value="BS Architecture">BS Architecture</option>
                                            <option value="Civil Engineering">Civil Engineering</option>
                                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Username:</label>
                                        <input value="<?php echo $accountInfo[0]['username']; ?>" type="text" class="form-control" id="" name="uname" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email:</label>
                                        <input value="<?php echo $accountInfo[0]['email']; ?>" type="email" class="form-control" id="" name="email" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-modify w-100" name="updateaccount">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <header style="height: 200px;"></header> -->
    <?php require_once 'footer.php' ?>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#course").val(`<?php echo $personalInfo[0]['course']; ?>`);
        });
    </script>
</body>

</html>