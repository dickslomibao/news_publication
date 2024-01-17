<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
require_once 'validate_viewer.php';
if (!isset($_GET['newsid'])) {
    header("Location: dashboard.php");
    return;
}
$success = false;
require_once "../../classes/news_getter.php";

$newslist = new Newslist;
$singlenews = $newslist->getSingleOnlySaveNews($_GET['newsid']);
if (isset($_POST['delete'])) {
    if (md5($_POST['password']) === $_SESSION['password']) {
        try {
            require_once "../../classes/news_class.php";
            $news = new News;
            $news->setId($_POST['newsid']);
            $news->deleteNews();
            $success = true;
        } catch (PDOException $th) {
            $error = "Something went wrong.";
        }
    } else {
        $error = "Invalid password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete News</title>
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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        .error {
            font-size: 15px;
            color: red;
            text-align: center;
            margin: 20px 0 10px 0;
        }

        .page-title {
            font-weight: 500;
            font-size: 18px;
            margin: 10px 0;
        }
    </style>
</head>

<body>
<?php if($success) {?>
    <script>
        swal("Success!", "News is deleted!", "success");
    </script>
    <?php header("Refresh: 3; url = news_list.php"); exit();}
    ?>
    <div class="margin-side">
        <div class="login-content">
            <form action="" method="post">
                <h1 class="logo">GA<span>ZSE</span>NT</h1>

                <h4 class="page-title">Enter password to continue</h4>
                <div class="form-group">
                    <input type="hidden" value="<?php echo $_GET['newsid']; ?>" class="form-control" id="" name="newsid" required>
                </div>
                <div class="form-group">
                    <label for="">Password:</label>
                    <input type="Password" class="form-control" id="" name="password" required>
                </div>
                
                <?php if (isset($error)) {
                    echo '<p class="error">' . $error . '.</p>';
                } ?>
                <div class="container-fluid" style="margin-top: 10px;">
                    <div class="row">
                        <div class="col-5" style="display:flex;justify-content:center;align-items:center">
                           <center>
                                <a href="news_list.php">Cancel</a>
                           </center>
                        </div>
                        <div class="col-7">
                            <button class="btn btn-success" name="delete" type="submit">Delete</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>