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
if(!isset($_GET['id']) || !isset($_GET['restrict'])){
    header("Location: dashboard.php");
    return;
}
if($_GET['id'] == "" || $_GET['restrict'] == ""){
    header("Location: dashboard.php");
    return;
}

require_once "../../classes/user_account_info.php";
$account = new AccountInformation;

if($_GET['restrict']==='true'){
    if(isset($_GET['user'])){
        if($account->restrict($_GET['id'],5)){
            header("Location: users.php");
        }
    }else{
        if($account->restrict($_GET['id'],5)){
            header("Location: view_writers.php");
        }
    }
       
}
else{

    if(isset($_GET['user'])){
        if($account->restrict($_GET['id'],2)){
            header("Location: users.php");
        }
    }else{
        if($account->restrict($_GET['id'],0)){
            header("Location: view_writers.php");
        }
    }
}
?>