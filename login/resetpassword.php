<?php
// Start a session (if not already started)
session_start();

// Include the navigation bar component
require_once "../components/navbar.php";

// Include the database connection file
require_once "../components/db_connect.php";

// Initialize error messages
$error = '';
$errorNew = '';

// Check if the "reset" form is submitted
if (isset($_POST["reset"])) {
  // Get the old password, new password, and confirm password from the submitted form
  $oldPass = $_POST["oldPass"];
  $newPass = $_POST["newPass"];
  $confirmPass = $_POST["confirmPass"];

  // Get the user's ID from the session (presumably, the user is logged in)
  $id = $_SESSION["user"];

  // SQL query to retrieve the user's data based on their ID
  $sql = "SELECT * FROM users WHERE id = $id";

  // Execute the SQL query
  $result = mysqli_query($connect, $sql);

  // Fetch the user's data
  $row = mysqli_fetch_assoc($result);

  // Hash the old password for comparison
  $oldPassHashed = hash("sha256", $oldPass);

  // Check if the hashed old password matches the stored hashed password
  if ($oldPassHashed == $row["password"]) {
    // Check if the new password and confirm password match
    if ($newPass == $confirmPass) {
      // Hash the new password
      $newPassHashed = hash("sha256", $newPass);

      // Update the user's password in the database with the new hashed password
      $resultNewPass = mysqli_query($connect, "UPDATE users SET password = '$newPassHashed' WHERE id = $id");

      if ($resultNewPass) {
        // Redirect the user to the index page after successfully changing the password
        header("refresh:3;url=../index.php");
        echo "Your password has been changed";
        exit();
      } else {
        // Display an error message if there was an issue updating the password
        echo "Error updating password: " . mysqli_error($connect);
      }
    } else {
      // Display an error message if the new password and confirm password don't match
      $errorNew = "The new password and confirm password are not matching";
    }
  } else {
    // Display an error message if the old password is incorrect
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