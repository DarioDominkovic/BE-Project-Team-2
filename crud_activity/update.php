<?php
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) { // if the session user and the session adm have no value
    header("Location: ../login/login.php"); // redirect the user to the home page
}
require_once "../components/db_connect.php";
require_once "../components/file_upload.php";
require_once "../components/navbar.php";

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
    } else {
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
    <title>Update Activity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS link -->
    <link rel="stylesheet" href="../index.css">
       
    <style>
        /* Additional custom styling */
        .mt-3 {
            margin-top: 1.5rem !important;
        }

        .btn-margin {
            margin-right: 0.5rem;
        }

        .update-activity{
            margin: 50px 50px;
        }
    </style>
</head>
<body>
    <?php echo $navbar ?>

    <h2 class="text-center mt-3">Update Activity</h2>
        
    <form class="update-activity" method="POST" enctype="multipart/form-data">
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $row["name"] ?>">
        </div>
        <div class="mb-3 mt-3">
            <label for="duration" class="form-label">Duration</label>
            <input type="time" class="form-control" id="duration" name="duration" value="<?= $row["duration"] ?>">
        </div>
            <div class="mb-3 mt-3">
                <label for="activity_order" class="form-label">Activity Order</label>
                <input type="number" class="form-control" id="activity_order" aria-describedby="activity_order" name="activity_order" value="<?= $row["activity_order"] ?>" min="1" max="50">
            </div>
            <div class="mb-3 mt-3">
                <label for="activity_points" class="form-label">Activity Points</label>
                <input type="number" class="form-control" id="activity_points" aria-describedby="activity_points" name="activity_points" value="<?= $row["activity_points"] ?>">
            </div>
            <div class="mb-3 mt-3">
                <label for="status" class="form-label">Activity Status</label>
                <fieldset>
                    <div>
                        <input type="radio" name="status" value="1" <?= ($row["status"] == 1) ? "checked" : ""; ?> />
                        <label for="status">Done</label>
                    </div>
                    <div>
                        <input type="radio" name="status" value="0" <?= ($row["status"] == 0) ? "checked" : ""; ?> />
                        <label for="status">Not Done</label>
                    </div>
                </fieldset>
            </div>
            <div class="mb-3">
                <label for="activity_picture" class="form-label">Picture</label>
                <input type="file" class="form-control" id="activity_picture" aria-describedby="activity_picture" name="activity_picture">
            </div>
            <button name="update" type="submit" class="btn btn-outline-primary btn-margin">Update Activity</button>
            <a href="../index.php" class="btn btn-outline-secondary btn-margin">Back to Home Page</a>
        </form>
        
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>