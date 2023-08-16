<?php
session_start();
if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){ // if the session user and the session adm have no value
  header("Location: ../login/login.php"); // redirect the user to the home page
}
require_once "../components/db_connect.php";
require_once "../components/file_upload.php";
    $id = $_GET["id"];
    $sql = "SELECT * FROM `activity` WHERE id = $id";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);
if (isset($_POST["update"])) {
    /* taking values from inputs */
    $name = $_POST["name"];
    $duration = $_POST["duration"];
    $activity_order = $_POST["activity_order"];
    $status = $_POST["status"];
    $activity_points = $_POST["activity_points"];
    $activity_picture = fileUpload($_FILES["activity_picture"], "crud_activity"); // Use correct input name
    /* checking if a picture has been selected */
    if ($_FILES["activity_picture"]["error"] == 0) {
        /* checking if the picture name of the product is not product.png to remove it from pictures folder */
        if ($row["activity_picture"] != "morning.png") {
            unlink("../pictures/$row[activity_picture]");
        }
        $sql = "UPDATE `activity` SET `name`='$name',`duration`='$duration',`activity_order`='$activity_order',`status`='$status',`activity_picture`='$activity_picture[0]' WHERE id={$id}";
    }
    else {
      $sql = "UPDATE `activity` SET `name`='$name',`duration`='$duration',`activity_order`='$activity_order',`status`='$status' WHERE id={$id}";
    }
    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
            Activity has been updated, {$activity_picture[1]}
          </div>";
        // header("refresh: 3; url= ../index.php");
    } else {
        echo "<div class='alert alert-danger' role='alert'>
            Error found, {$activity_picture[1]}
          </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Update Activity</h2>
        <form method="POST" enctype="multipart/form-data">
        <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $row["name"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="duration" class="form-label">Duration</label>
                <input type="text" class="form-control" id="duration" aria-describedby="name" name="duration" value="<?= $row["duration"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="activity_order" class="form-label">Activity order</label>
                <input type="text" class="form-control" id="activity_order" aria-describedby="activity_order" name="activity_order" value="<?= $row["activity_order"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="activity_points" class="form-label">Activity points</label>
                <input type="text" class="form-control" id="activity_points" aria-describedby="activity_points" name="activity_points" value="<?= $row["activity_points"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="Status" class="form-label">Status</label>
                <input type="text" class="form-control" id="Status" aria-describedby="status" name="status" value="<?= $row["status"] ?>">
            </div>
            <div class="mb-3">
                <label for="activity_picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="activity_picture" aria-describedby="activity_picture" name="activity_picture">
            </div>
            <button name="update" type="submit" class="btn btn-primary">Update product</button>
            <a href="index.php" class="btn btn-warning">Back to home page</a>
        </form>
    </div>
</body>
</html>