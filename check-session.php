<?php
include("database-conf.php");
session_start();

if(!isset($_SESSION['ID'])){
   header("location:sign_in.php");
   die();
}

$user_check = $_SESSION['ID'];
$result1 = $conn->query("SELECT username FROM users WHERE USER_ID  = '$user_check' ");

  $row = mysqli_fetch_array($result1,MYSQLI_ASSOC);

  $login_session = $row['username'];



 ?>
