<?php

session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

$user_id = $_SESSION['user'];
            $routine_activities_query = "SELECT a.*, ra.* FROM `activity` a
                JOIN `routine_activity` ra ON a.id = ra.fk_activity
                WHERE ra.fk_users = $user_id";
            $routine_activities_result = mysqli_query($connect, $routine_activities_query);

if (isset($_GET['deleteRoutine']) && isset($_GET['id']) ) 
{
    $id = $_GET['id'];
    echo $delete = "DELETE FROM `routine_activity` WHERE id = $id";
    
    if(mysqli_query($connect, $delete)){
        mysqli_close($connect);
        header('location: routine.php');
    } else {
        echo "Error";   
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
    
    <link rel="stylesheet" href="index.css">

    <title>My Routine</title>
</head>

<body>
    <?php echo $navbar ?>

    <h1 class="text-center" style="padding:25px 0px">My Routine</h1>

    <?php
         if (mysqli_num_rows($routine_activities_result) > 0) {
                while ($row = mysqli_fetch_assoc($routine_activities_result)) {
    ?>
        <div class="index-card-container">
            <div class="index-card-2">       
                <div class="index-card-image">
                                        <?php
                                        if (!empty($row['activity_picture'])) {
                                            if (filter_var($row['activity_picture'], FILTER_VALIDATE_URL)) {
                                                echo '<img src="' . $row['activity_picture'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                                            } else {
                                                echo '<img src="pictures/' . $row['activity_picture'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                                            }
                                        } else {
                                            echo '<img src="default-image.jpg"  class="card-img-top" alt="' . $row['name'] . '">';
                                        }
                                        ?>
                </div>
                <div class="index-card-description">

                                    <h3 class="text-center"><?php echo $row['name']; ?></h3>

                                    <a class="d-block mt-5 justify-content-center text-center rounded-pill text-uppercase" href="crud_activity/show.php?id=<?php echo $row['id']; ?>" class="btn">Show</a>
                                    <a class="d-block mt-3 justify-content-center text-center rounded-pill text-uppercase" href="routine.php?deleteRoutine=true&id=<?php echo $row['id']; ?>" class="btn ms-2">Delete</a>
                                </div>
                            
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="col text-center"><p>No routine activities added</p></div>';
            }
            ?>
     
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>


