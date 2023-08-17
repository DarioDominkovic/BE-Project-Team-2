<?php
session_start();


require_once "./components/db_connect.php";
$error = '';

if (isset($_POST["reset"])) {
  $oldPass = $_POST["oldPass"];
  $newPass = $_POST["newPass"];
  $confirmPass = $_POST["confirmPass"];

  $id = $_SESSION["user"];
  $sql = "select * from users where id = $id";
  $result = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($result);

  $oldPassHashed = hash("sha256", $oldPass);

  if ($oldPassHashed == $row["password"]) {
    if ($newPass == $confirmPass) {
      $newPassHashed = hash("sha256", $newPass);
      $resultNewPass = mysqli_query($connect, "UPDATE users SET password = '$newPassHashed' WHERE id = $id");
      if ($resultNewPass) {
        echo "success";
      }
    } else {
      $errorNew = "The new password and confirm password are not matching";
    }
  } else {
    $error =  "The old password is wrong";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <form method="POST">
    <input type="text" name="oldPass" placeholder="your old password">
    <p><?= $error ?></p>
    <input type="text" name="newPass" placeholder="your new password"><br>
    <input type="text" name="confirmPass" placeholder="confirm password">
    <p><?= $errorNew ?></p>

    <input type="submit" name="reset" value="Reset password">
  </form>
</body>

</html>