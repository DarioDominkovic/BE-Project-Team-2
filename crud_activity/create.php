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
    $status = $_POST["status"];
    $activity_pictures = $_POST["activity_pictures"];
    $activity_points = $_POST["activity_points"];
    $activity_picture = fileUpload($_FILES["activity_picture"]);

    $sql = "INSERT INTO activity (`name`, `duration`, `activity_order`, `status`, `activity_picture`, `activity_points`) VALUES ('$name','$duration','$activity_order', '$status', '{$activity_picture[0]}', '$activity_points')";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Create a New Activity</title>
    <style>
        /* Additional custom styling */
        .mt-3 {
            margin-top: 1.5rem !important;
        }

        .btn-margin {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>

    <?php echo $navbar ?>

    <div class="container mt-5">
        <h2>Create a New Activity</h2>
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
                <label for="activity_order" class="form-label">Activity Order</label>
                <input type="number" class="form-control" id="activity_order" aria-describedby="activity_order" name="activity_order" min="1" max="50">
            </div>
            <div class="mb-3 mt-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="0">Not Done</option>
                    <option value="1">Done</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="activity_picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="activity_picture" aria-describedby="activity_picture" name="activity_picture">
            </div>
            <button name="create" type="submit" class="btn btn-outline-primary btn-margin">CREATE ACTIVITY</button>
            <a href="../index.php" class="btn btn-outline-secondary btn-margin">BACK TO ACTIVITY LIST</a>
        </form>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>