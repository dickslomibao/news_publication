<?php
require_once "../../classes/comment_class.php";

$comments = new Comment;
$valid = false;
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    return;
}
if(!isset($_GET['id'])){
    header("Location: newsview.php");
    return;
}

$data = $comments->getComment($_GET['id'],$_SESSION['id']);
if(count($data)===0){
    header("Location: newsview.php");
    return;
}else{
    $comments->delete($_GET['id'],$_SESSION['id']);
    $valid = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Comment</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="shortcut icon" href="../../assets/newsassets/logo.jpg" type="image/x-icon">

</head>
<body>
<?php if($valid) {?>
    <script>
        swal("Success!", "Your Comment is deleted!", "success");
    </script>
    <?php header("Refresh: 2; url = ".urldecode($_GET['link'])); exit();}
    ?>
</body>
</html>
