<?php
session_start();
if (!isset($_SESSION['company_id'])) {
    header("location:index.php");
    exit();
}else{ 
    $_SESSION = array(); 
    session_destroy(); 
    header("location:../index.php");
    exit();
}
