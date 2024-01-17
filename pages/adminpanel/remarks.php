<?php
require_once "../../classes/comment_class.php";
require_once '../../classes/news_class.php';
$error = "";
$news = new News;
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../site/login.php");
    return;
}
if ($_SESSION['validator'] !== "1") {
    header("Location: ../site/login.php");
    return;
}

if(isset($_POST['submit'])){
    $news->setRemarks([$_POST['remarks'],$_POST['id']]);
    header('Location: unpublish_news.php');
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
        <div class="login-content" style="min-width: 600px;">
            <form action="" method="post">
                <h1 class="logo">GA<span>ZSE</span>NT</h1>
                <h4 class="page-title">Set remarks</h4>
                <div class="form-group">
                    <input type="hidden" value="<?php echo $_GET['newsid'] ?>"  name="id">
                    <label for="">Your Remarks:</label>
                    <textarea name="remarks" class="form-control" id="" cols="10" rows="5"></textarea>
                </div>
                <button class="btn btn-success" name="submit" type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>