<?php 

if($_SESSION['role'] === '2'){
    header("Location: ../../");
    return;
}

if($_SESSION['role'] === '5'){
    header("Location: restricted.php");
    return;
}

?>
