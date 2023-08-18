<?php
session_start();
$raus = "../";
$rein = "";
require_once "../components/db_connect.php";
require_once "../components/navbar.php";
require_once "../components/file_upload.php";

$idToUpdate = $_GET["id"];
if (isset($_SESSION["user"])) {
  $idToUpdate = $_SESSION["user"];
} // Check if the user is logged in
if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
  // Redirect unauthorized users to a login page or display an error message
  header("Location: {$raus}/login/login.php");
  exit;
}

// If user is not an admin and trying to access another user's account
if (!isset($_SESSION["adm"]) && $_SESSION["user"] != $idToUpdate) {
  // Redirect to an error page or display an error message
  header("Location: {$raus}access_denied.php");
  exit;
}

// Fetch user details for the specified user ID
$sql = "SELECT * FROM users WHERE id = $idToUpdate";
$result = mysqli_query($connect, $sql);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if (isset($_POST["update_user"])) {
    // Update user account details
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $user_picture = fileUpload($_FILES["user_picture"], "user");
    $create_date = $_POST["create_date"];
    $status = $_POST["status"];

    // Delete previous user picture if not default
    if ($row["user_picture"] != "avatar.png") {
      $picturePath = "./pictures/" . $row["user_picture"];
      if (file_exists($picturePath)) {
        if (unlink($picturePath)) {
          echo "<div class='text-center bg-info'>Previous picture deleted successfully.</div>";
        } else {
          echo "<div class='text-center bg-danger'>Error deleting previous picture.</div>";
        }
      }
    }

    // Perform the update query
    $sqlUpdate = "UPDATE `users` SET `fname`='$fname',`lname`='$lname',`username`='$username',`email`='$email',`user_picture`='$user_picture[0]',`create_date`='$create_date',`status`='$status' WHERE id = $idToUpdate";

    if (mysqli_query($connect, $sqlUpdate)) {
      echo "<div class='text-center bg-success'>Success! User details updated.</div>";
    } else {
      echo "<div class='text-center bg-danger'>Error updating user details: " . mysqli_error($connect) . "</div>";
    }
  }
} else {
  echo "<div class='text-center bg-danger'>Error fetching user details: " . mysqli_error($connect) . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <title>Update Users</title>
</head>

<body>
  <!-- navbar starts -->
  <?= $navbar ?>
  <!-- navbar ends -->

  <div class="container mt-5">
    <h2>Update Users</h2>
    <form method="post" enctype="multipart/form-data">
      <!-- Displaying the current values of the media record in the form for updating -->
      <div class="mb-3 mt-3">
        <label for="fname" class="form-label">First Name</label>
        <input type="text" class="form-control" name="fname" aria-describedby="fname" id="fname" value="<?php echo $row["fname"]; ?>" />
      </div>
      <div class="mb-3 mt-3">
        <label for="lname" class="form-label">Last Name</label>
        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row["lname"]; ?>" />
      </div>

      <div class="mb-3 mt-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" name="username" aria-describedby="username" id="username" value="<?php echo $row["username"]; ?>" />
      </div>
      <div class="mb-3 mt-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" aria-describedby="email" id="email" value="<?php echo $row["email"]; ?>" />
      </div>

      <div class="mb-3 mt-3">
        <label for="user_picture" class="form-label">User Picture</label>
        <input type="file" class="form-control" name="user_picture" aria-describedby="user_picture" id="user_picture" />
        <small class="text-muted">Leave blank to keep the existing picture.</small>
      </div>

      <div class="mb-3 mt-3">
        <label for="create_date" class="form-label">Date of Creation</label>
        <input type="text" class="form-control" name="create_date" aria-describedby="create_date" id="create_date" value="<?php echo $row["create_date"]; ?>" disabled />
      </div>
      <div class="mb-3 mt-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" name="status" aria-describedby="status" id="status">
          <option value="active" <?php echo ($row["status"] === "active") ? "selected" : ""; ?>>Active</option>
          <option value="inactive" <?php echo ($row["status"] === "inactive") ? "selected" : ""; ?>>Inactive</option>
        </select>
      </div>
      <button type="submit" name="update_user" class="btn btn-outline-secondary">UPDATE USER</button>
    </form>
  </div>

  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw5f+ua6qOJ6TnFdARDVx4PvQA4f6V9kD4Z5d4DFOxJ+5n6USvUew+OrCXaRkf" crossorigin="anonymous"></script>
</body>

</html>