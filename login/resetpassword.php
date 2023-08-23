<?php
session_start();
require_once "../components/navbar.php";
require_once "../components/db_connect.php";
$error = '';
$errorNew = '';

if (isset($_POST["reset"])) {
  $oldPass = $_POST["oldPass"];
  $newPass = $_POST["newPass"];
  $confirmPass = $_POST["confirmPass"];

  $id = $_SESSION["user"];
  $sql = "SELECT * FROM users WHERE id = $id";
  $result = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($result);

  $oldPassHashed = hash("sha256", $oldPass);

  if ($oldPassHashed == $row["password"]) {
    if ($newPass == $confirmPass) {
      $newPassHashed = hash("sha256", $newPass);
      $resultNewPass = mysqli_query($connect, "UPDATE users SET password = '$newPassHashed' WHERE id = $id");

      if ($resultNewPass) {
        header("refresh:3;url=../index.php");
        echo "your password has been changed";
        exit();
      } else {
        echo "Error updating password: " . mysqli_error($connect);
      }
    } else {
      $errorNew = "The new password and confirm password are not matching";
    }
  } else {
    $error = "The old password is wrong";
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../index.css">
  <style>
    :root {
      --one: #233142;
      --two: #455d7a;
      --three: #f95959;
      --black: #1d1d1d;
      --white: #e3e3e3;
    }

    body {
      color: var(--white);
    }

    .card-header {
      background-color: var(--two);
      color: var(--white);
    }

    .btn-outline-secondary {
      background-color: #233142;
      border-color: var(--two);
      color: var(--white);

    }

    .btn-outline-secondary:hover {
      background-color: var(--three);
    }
  </style>
  <title>Password Reset</title>
</head>

<body>
  <?php echo $navbar ?>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Password Reset
          </div>
          <div class="card-body">
            <form method="POST">
              <div class="mb-3">
                <input type="password" class="form-control" name="oldPass" placeholder="Your old password">
              </div>
              <p><?= $error ?></p>
              <div class="mb-3">
                <input type="password" class="form-control" name="newPass" placeholder="Your new password">
              </div>
              <div class="mb-3">
                <input type="password" class="form-control" name="confirmPass" placeholder="Confirm password">
              </div>
              <p><?= $errorNew ?></p>
              <div class="d-grid gap-2">
                <button class="btn btn-outline-secondary" type="submit" name="reset">Reset password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>