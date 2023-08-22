<?php
require_once "db_connect.php";
if (isset($_POST["submit"])) {
  $email = $_POST["email"];
  $length = 10;
  $newPass = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
  $newPassHashed = hash("sha256", $newPass);
  $sql = "SELECT * FROM users WHERE email = '$email' OR username = '$email'";
  $result = mysqli_query($connect, $sql);
  if ($result->num_rows == 1) {
    $row = mysqli_fetch_assoc($result);
  }
  mysqli_query($connect, "UPDATE users SET password = '$newPassHashed' WHERE email = '$email' OR username= '$email'");
  $message = "<h1>Your new password</h1>
        <p>Hey Dear {$row["fname"]}, your new password for your account is : $newPass</p>";
  if (mail($row["email"], "New password for $email", $message)) {
    echo "<h1>New password has been sent to $email, please check your email and login with the new password</h1>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <form method="post">
    <input type="text" name="email" placeholder="Please type your email or username">
    <input type="submit" value="Send new Password" name="submit">
  </form>
</body>

</html>