<?php
require_once "./components/db_connect.php";
$key = $_GET["key"];
$email = $_GET["email"];
$pass = uniqid();
  if(isset($key) && isset($email)){

    $sql = "UPDATE users SET password = '$pass' WHERE email = '$email'";
    mysqli_query($connect, $sql);
    mail($email, "your new password", "Your new password is $pass ");
  }
