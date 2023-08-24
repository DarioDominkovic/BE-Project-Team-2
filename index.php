<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";


// ---------------------------------- THE LOGIN ALERT'S OF THE DAY CODE ----------------------------------

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
    $user_query = "SELECT last_login_date FROM users WHERE id = $user_id";
    $user_result = mysqli_query($connect, $user_query);

    if ($user_result) {
        $user_row = mysqli_fetch_assoc($user_result);
        $last_login_date = $user_row['last_login_date'];

        $current_date = date('Y-m-d');

        if ($last_login_date !== $current_date) {
            $update_query = "UPDATE users SET last_login_date = '$current_date' WHERE id = $user_id";
            mysqli_query($connect, $update_query);

            // first login of the day
            echo '<div id="firstLoginAlert" class="alert alert-success">Hello! Lets start your Routine</div>';
        }
    } else {
        echo "Error fetching user data: " . mysqli_error($connect);
    }
}

// ---------------------------------- THE FIRST LOGIN ALERT OF THE DAY CODE ----------------------------------

$sql = "SELECT * FROM activity";
$result = mysqli_query($connect, $sql);


if (isset($_POST["addtoroutine"])) {
    $user_id = $_SESSION['user'];
    $activity_id = $_POST["id"];

    $routine_id = 1;
    $max_order_query = "SELECT MAX(activity_order) AS max_order FROM `routine_activity` WHERE `fk_routine` = '$routine_id'";
    $max_order_result = mysqli_query($connect, $max_order_query);
    $max_order_row = mysqli_fetch_assoc($max_order_result);
    $next_activity_order = ($max_order_row['max_order'] !== null) ? $max_order_row['max_order'] + 1 : 1;

    $routine_id = mysqli_insert_id($connect);
    $res = mysqli_query($connect, "SELECT * FROM routine_activity WHERE fk_activity = $activity_id AND fk_users = $user_id");

        $routine_activity_sql = "INSERT INTO `routine_activity`(`fk_activity`, `fk_routine`, `fk_users`, `activity_order`) VALUES ('$activity_id','$routine_id','$user_id', '$next_activity_order')";
    


    if ($res->num_rows == 0 && mysqli_query($connect, $routine_activity_sql)) {
        echo "<div class='alert alert-success' role='alert'>
        Congrats, you added a new activity to your morning routine!
        </div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>
                Sorry, morning routine is already exists!
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

    <!-- CSS LINK -->
    <link rel="stylesheet" href="index.css">

    <title>Activities</title>
</head>

<body>
    <!-- Navbar start-->
    <?php echo $navbar ?>
    <!-- Navbar end-->

    <h1 class="text-center" style="padding-top:25px">Activities</h1>

    <h5 class="text-center" style="color:grey;">First create a routine and add your activities later</h5>

    <?php


    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
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
                        <a class="d-block my-3 justify-content-center text-center rounded-pill text-uppercase" href="crud_activity/update.php?id=<?php echo $row['id']; ?>" class="btn ms-2">Edit</a>
                        <a class="d-block mb-3 justify-content-center text-center rounded-pill text-uppercase" href="crud_activity/delete.php?id=<?php echo $row['id']; ?>" class="btn ms-2">Delete</a>

                        <?php
                        if(isset($_SESSION["user"])) {
?>
                        <form method="post">
                            <input type="hidden" name="addtoroutine" value="1">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="mt-2" name="addtoroutine">Add to Routine</button>
                        </form>
                        <?php
                    }?>
                    </div>
                </div>
            </div>


    <?php
        }
    } else {
        echo '<div class="col"><p>Media not found.</p></div>';
    }
    ?>

    <div class="d-block mb-3 justify-content-center text-center">
        <a href="crud_activity/create.php" class="text-center btn btn-outline-secondary my-5"> ADD MORE ACTIVITES </a>
    </div>


    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>

    <script>
        // ---------------------------------- LOGIN ALERT TIMER ----------------------------------  

        setTimeout(function() {
            var firstLoginAlert = document.getElementById("firstLoginAlert");
            if (firstLoginAlert) {
                firstLoginAlert.style.display = "none";
            }
        }, 50000);

        setTimeout(function() {
            var subsequentLoginAlert = document.getElementById("subsequentLoginAlert");
            if (subsequentLoginAlert) {
                subsequentLoginAlert.style.display = "none";
            }
        }, 50000);

        // ---------------------------------- LOGIN ALERT TIMER ----------------------------------
    </script>

</body>

</html>