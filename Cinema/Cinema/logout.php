<?php
session_start();
include("Model/db.php");
if (isset($_COOKIE['token'])) {
    $token=$_COOKIE['token'];
    $sql=mysqli_query($connection,"UPDATE user SET token='' WHERE token='$token'") ;
    if($sql){
        setcookie('token', '', time() - 3600, '/');
        header("Location: login.php"); 
        exit;
    }
    
} else {
    header("Location: login.php");
    exit;
}
?>
