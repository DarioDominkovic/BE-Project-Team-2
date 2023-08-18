<?php
session_start();


require_once "./components/db_connect.php";
$error = '';
$errorNew = '';


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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Password Reset</title>
</head>

<body>

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
                <input type="text" class="form-control" name="oldPass" placeholder="Your old password">
              </div>
              <p><?= $error ?></p>
              <div class="mb-3">
                <input type="text" class="form-control" name="newPass" placeholder="Your new password">
              </div>
              <div class="mb-3">
                <input type="text" class="form-control" name="confirmPass" placeholder="Confirm password">
              </div>
              <p><?= $errorNew ?></p>
              <div class="d-grid gap-2">
                <button class="btn btn-outline-primary" type="submit" name="reset">Reset password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>