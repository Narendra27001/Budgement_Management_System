<?php
session_start();
if(isset($_SESSION['email'])){
    header('location:index.php');
}
//To clear all the session values and logout
session_unset();
session_destroy();
header('location:index.php');