<?php 
session_start();
ob_start();
include_once 'data/class.php';
$adminclass = new AdminClass();
$user_id = $_SESSION['user_id'];


?>