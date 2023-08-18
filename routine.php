<?php

session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

?>

<!DOCTYPE html>
<html lang="en">

<body>
    <?php echo $navbar ?>

    <div class="container">
        <div class="row">
            <?php
            $user_id = $_SESSION['user'];

            $routine_activities_query = "SELECT a.* FROM `activity` a
                JOIN `routine_activity` ra ON a.id = ra.fk_activity
                WHERE ra.fk_users = $user_id";
            
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
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="col"><p>No activity found in your morning routine.</p></div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>


