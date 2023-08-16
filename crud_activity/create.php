<?php

    session_start();
    
    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){ // if the session user and the session adm have no value
        header("Location: ../login/login.php"); // redirect the user to the home page
    }
    
    require_once "../components/db_connect.php";
    require_once "../components/file_upload.php";

    if(isset($_POST["create"])){
        $name = $_POST["name"];
        $duration = $_POST["duration"];
        $activity_order = $_POST["activity_order"];
        $status = $_POST["status"];
        $activity_pictures = $_POST["activity_pictures"];
        $activity_points = $_POST["activity_points"];
        $activity_picture = fileUpload($_FILES["activity_picture"]);

        $sql = "INSERT INTO activity (`name`, `duration`, `activity_order`, `status`, `activity_picture`, `activity_points`) VALUES ('$name','$duration','$activity_order', '$status', '{$activity_picture[0]}', '$activity_points')";
        if(mysqli_query($connect, $sql)){
            echo "<div class='alert alert-success' role='alert'>
            New record has been created, {$activity_picture[1]}
          </div>";
          header("refresh: 3; url= ../index.php");
        }else {
            echo "<div class='alert alert-danger' role='alert'>
            error found, {$activity_picture[1]}
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
        <h2>Create a new Activity</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="duration" class="form-label">Duration</label>
                <input type="text" class="form-control" id="duration" aria-describedby="name" name="duration">
            </div>
            <div class="mb-3 mt-3">
                <label for="activity_order" class="form-label">Activity order</label>
                <input type="text" class="form-control" id="activity_order" aria-describedby="activity_order" name="activity_order">
            </div>
            <div class="mb-3 mt-3">
                <label for="Status" class="form-label">Status</label>
                <input type="text" class="form-control" id="Status" aria-describedby="status" name="status">
            </div>
            <div class="mb-3">
                <label for="activity_picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="activity_picture" aria-describedby="activity_picture" name="activity_picture">
            </div>
            <button name="create" type="submit" class="btn btn-primary">Create product</button>
            <a href="index.php" class="btn btn-warning">Back to home page</a>
        </form>
    </div>
    
</body>
</html>