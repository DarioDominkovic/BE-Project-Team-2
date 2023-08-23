<?php
require_once "../components/db_connect.php";
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
  <title>Password Reset</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="login.css">

</head>

<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Password Reset</h4>
            <form method="post">
              <div class="form-group">
                <label for="email">Email or Username</label>
                <input type="text" class="form-control myInput" name="email" id="email" placeholder="Enter your email or username" required>
              </div>
              <br>
              <button type="submit" class="btn mt-3 myBtn" name="submit">Send New Password</button>
            </form>
            <a href="login.php" class="btn mt-3 myBtn">Back to Log In</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>