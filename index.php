<?php
session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

$sql = "SELECT * FROM activity";
$result = mysqli_query($connect, $sql);


if(isset($_POST["addtoroutine"])){

    $user_id = $_SESSION['user'];
    $activity_id = $_POST["id"];
    $routine_id = $_POST["routine_id"];



    $sql = "INSERT INTO `routine_activity`(`fk_activity`, `fk_routine`, `fk_users`) VALUES ($activity_id,$routine_id,$user_id)";

    if (mysqli_query($connect, $sql)){
        echo "<div class='alert alert-success' role='alert'>
        Congrats, you added a new activity to your morning routine!
        </div>";
        // header("refresh: 3; url = home.php");
    }
    else {
        echo "<div class='alert alert-danger' role='alert'>
                Sorry, morning routine could not get updated!
                </div>";
    }
}

$sql_user_routines = "SELECT DISTINCT r.id, r.routine_name 
                      FROM routine r
                      JOIN routine_activity ra ON r.id = ra.fk_routine
                      WHERE ra.fk_users = ?";

$stmt = mysqli_prepare($connect, $sql_user_routines);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user']);
mysqli_stmt_execute($stmt);
$result_user_routines = mysqli_stmt_get_result($stmt);
$all_routines = mysqli_fetch_all($result_user_routines);



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
    
    <link rel="stylesheet" href="components/navbar.css">

    <title>Activities</title>
</head>


</head>

<body>

    <!-- Navbar -->
    <?php echo $navbar ?>

    <h1>Activities</h1>

    <div class="container">
 
    <div class="row">

    <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
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

                                <form method="post">
                                <input type="hidden" name="addtoroutine" value="1">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                <!-- Dropdown for selecting routine -->
                                <select name="routine_id" class="form-select mb-2" required>
                                    <option value="" disabled selected>Select Routine</option>
                                    <?php
                                    foreach ($all_routines as $routine) {
                                        echo '<option value="' . $routine[0] . '">' . $routine[1] . '</option>';
                                    }
                                    ?>
                                </select>
                               

                                <button type="submit" class="btn btn-primary" name="addToRoutineBtn">Add to Routine</button>
                            </form>
                            </div>
                        </div>

                    </div>
            <?php
                }
            } else {
                echo '<div class="col"><p>Media not found.</p></div>';
            }
            ?>
        </div>
    </div>

        <div class="container center-screen">
        <a href="crud_activity/create.php" class="btn btn-outline-secondary"> ADD MORE ACTIVITES </a>
        </div>

    </div>



    

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>