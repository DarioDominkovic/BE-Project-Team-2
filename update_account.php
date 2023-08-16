<?php
session_start();
require_once "./component/db_connect.php";
require_once "./component/navbar.php";
require_once "./component/file_upload.php";

$id = $_GET["x"];  // in navbar before the href (link?)update_account.php?x=some_id...

$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($connect, $sql);

if ($result) {
  $row = mysqli_fetch_assoc($result);

  if (isset($_POST["update_user"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $user_picture = fileUpload($_FILES["user_picture"], "user");
    $create_date = $_POST["create_date"];
    $status = $_POST["status"];

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

    $sql = "UPDATE `users` SET `fname`='$fname',`lname`='$lname',`username`='$username',`email`='$email',`user_picture`='$user_picture[0]',`create_date`='$create_date',`status`='$status' WHERE id = $id";

    if (mysqli_query($connect, $sql)) {
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
        <label for="fname" class="form-label">First name</label>
        <input type="text" class="form-control" name="fname" area-describility="fname" id="fname" value="<?php echo $row["fname"]; ?>" />
      </div>
      <div class="mb-3 mt-3">
        <label for="lname" class="form-label">Last name</label>
        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row["lname"]; ?>" />
      </div>

      <div class="mb-3 mt-3">
        <label for="username" class="form-label">User name</label>
        <input type="text" class="form-control" name="username" area-describility="username" id="username" value="<?php echo $row["username"]; ?>" />
      </div>
      <div class="mb-3 mt-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" name="email" area-describility="email" id="email" value="<?php echo $row["email"]; ?>" />
      </div>

      <div class="mb-3 mt-3">
        <label for="user_picture" class="form-label">User picture</label>
        <input type="file" class="form-control" name="user_picture" area-describility="user_picture" id="user_picture" value="<?php echo $row["user_picture"]; ?>" />
      </div>

      <div class="mb-3 mt-3">
        <label for="create_date" class="form-label">Date of Creation</label>
        <input type="text" class="form-control" name="create_date" area-describility="create_date" id="create_date" value="<?php echo $row["create_date"]; ?>" />
      </div>
      <div class="mb-3 mt-3">
        <label for="status" class="form-label">Status</label>
        <input type="text" class="form-control" name="status" area-describility="status" id="status" value="<?php echo $row["status"]; ?>" />
      </div>
      <button type="submit" name="update_user" class="btn btn-primary">UPDATE USER</button>
    </form>
  </div>

  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</body>

</html>