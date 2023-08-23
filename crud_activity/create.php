<?php

session_start();

$raus = "../";
$rein = "";
require_once "../components/navbar.php";

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) { // if the session user and the session adm have no value
    header("Location: ../login/login.php"); // redirect the user to the home page
}

require_once "../components/db_connect.php";
require_once "../components/file_upload.php";

if (isset($_POST["create"])) {
    $name = $_POST["name"];
    $duration = $_POST["duration"];
    $activity_order = $_POST["activity_order"];
    // $status = $_POST["status"];
    $activity_points = $_POST["activity_points"];
    $activity_picture = fileUpload($_FILES["activity_picture"]);

    $sql = "INSERT INTO activity (`name`, `duration`, `activity_order`, `activity_picture`, `activity_points`) VALUES ('$name','$duration','$activity_order', '{$activity_picture[0]}', '$activity_points')";
    if (mysqli_query($connect, $sql)) {
        echo "<div class='alert alert-success' role='alert'>
            New record has been created, {$activity_picture[1]}
          </div>";
        header("refresh: 3; url= ../index.php");
    } else {
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

    <!-- favicon link -->
    <link rel="icon" type="pictures/png" href="pictures/logo.png">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <!-- CSS link -->
    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="crud_activity.css">

    <title>Create new activity</title>
</head>

<body>

    <?php echo $navbar ?>

    <h1 class="text-center mt-3">Create a new activity</h1>

    <div class="container mt-5 createActivity">

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="name" name="name">
            </div>
            <div class="mb-3 mt-3">
                <label for="duration" class="form-label">Duration</label>
                <input type="time" class="form-control" id="duration" name="duration">
            </div>
            <div class="mb-3 mt-3">
                <label for="activity_order" class="form-label">Activity order</label>
                <input type="number" class="form-control" id="activity_order" aria-describedby="activity_order" name="activity_order" min="1" max="50">
            </div>
            <div class="mb-3 mt-3">
                <label for="activity_points" class="form-label">Activity points</label>
                <input type="number" class="form-control" id="activity_points" aria-describedby="activity_points" name="activity_points" min="0">
            </div>
            <div class="mb-3">
                <label for="activity_picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="activity_picture" aria-describedby="activity_picture" name="activity_picture">
            </div>
            <br><br>
            <button name="create" type="submit" class="btn myBtn">CREATE ACTIVITY</button>
            <br><br>
            <a href="../index.php" class="btn myBtn">BACK TO ACTIVITY LIST</a>
        </form>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>