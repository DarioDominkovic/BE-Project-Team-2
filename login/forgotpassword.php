<?php
// Include the database connection file
require_once "../components/db_connect.php";

// Check if the form is submitted
if (isset($_POST["submit"])) {
  // Get the email from the submitted form
  $email = $_POST["email"];

  // Generate a new password with 10 characters
  $length = 10;
  $newPass = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);

  // Hash the new password using SHA-256
  $newPassHashed = hash("sha256", $newPass);

  // SQL query to check if the email or username exists in the 'users' table
  $sql = "SELECT * FROM users WHERE email = '$email' OR username = '$email'";

  // Execute the SQL query
  $result = mysqli_query($connect, $sql);

  // Check if exactly one row matches the email or username
  if ($result->num_rows == 1) {
    // Fetch the user data
    $row = mysqli_fetch_assoc($result);
  }

  // Update the user's password in the database with the new hashed password
  mysqli_query($connect, "UPDATE users SET password = '$newPassHashed' WHERE email = '$email' OR username= '$email'");

  // Create a message to send to the user via email
  $message = "<h1>Your new password</h1>
        <p>Hey Dear {$row["fname"]}, your new password for your account is : $newPass</p>";

  // Send an email to the user with the new password
  if (mail($row["email"], "New password for $email", $message)) {
    // Display a success message if the email was sent
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