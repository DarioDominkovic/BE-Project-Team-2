<?php

session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon link -->
    <link rel="icon" type="pictures/png" href="images/favicon-book.png">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <link rel="stylesheet" href="index.css">

    <title>Routine</title>
</head>
<body>
    <?php echo $navbar ?>

    <div class="container">
        <div class="row">
            <?php
            $user_id = $_SESSION['user'];
            $selected_routine_id = $_GET['routine_id'];

            //as in routine.php a as activity and ra as routine_activity
            $routine_activities_query = "SELECT a.* FROM `activity` a
                JOIN `routine_activity` ra ON a.id = ra.fk_activity
                WHERE ra.fk_users = $user_id AND ra.fk_routine = $selected_routine_id";
            
            $routine_activities_result = mysqli_query($connect, $routine_activities_query);

            if (mysqli_num_rows($routine_activities_result) > 0) {
                while ($row = mysqli_fetch_assoc($routine_activities_result)) {
            ?>
                    <div class="col-md-4 mb-4">

                        <div class="card h-100">
                            <?php
                            if (!empty($row['activity_picture'])) {
                                if (filter_var($row['activity_picture'], FILTER_VALIDATE_URL)) {
                                    echo '<img src="' . $row['activity_picture'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                                } else {
                                    echo '<img src="pictures/' . $row['activity_picture'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                                }
                            } else {
                                echo '<img src="default-image.jpg" class="card-img-top" alt="' . $row['name'] . '">';
                            }
                            ?>

                            <h4 class="card-title position-absolute bottom-0 start-0 mb-2 mx-2" style="color: white; font-size: 25px;"><?php echo $row['name']; ?></h4>
                            <div class="buttons d-flex justify-content-center">
                                <a href="crud_activity/show.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-success">Show</a>
                                <a href="crud_activity/update.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary ms-2">Edit</a>
                                <a href="crud_activity/delete.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger ms-2">Delete</a>

                            </div>
                        </div>

                    </div>
            <?php
                }
            } else {
                echo '<div class="col"><p>No activity found in the selected routine.</p></div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
