<?php
session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

$sql = "SELECT * FROM activity";
$result = mysqli_query($connect, $sql);

$sql_name = "SELECT DISTINCT name FROM activity";
$result_name = mysqli_query($connect, $sql_name);
$publishers = mysqli_fetch_all($result_name, MYSQLI_ASSOC);     
// was ist das publishers? we dont need it, right?



if(isset($_POST["addtoroutine"])){

    $user_id = $_SESSION['user'];
    $activity_id = $_POST["id"];

    $routine_name = "Morning Routine";
    $routine_description = "Description of morning routine";

    $routine_sql = "INSERT INTO `routine`(`routine_name`, `description`) VALUES ('$routine_name','routine_description')";
    $sql = "INSERT INTO `routine_activity`(`id`, `fk_activity`, `fk_routine`, `fk_users`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]')";

    mysqli_query($connect, $routine_sql);
    $routine_id = mysqli_insert_id($connect);

    $routine_activity_sql = "INSERT INTO `routine_activity`(`fk_activity`, `fk_routine`, `fk_users`) VALUES ('$activity_id','$routine_id','$user_id')";

    if (mysqli_query($connect, $routine_activity_sql)){
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



?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="/components/navbar.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon link -->
    <link rel="icon" type="pictures/png" href="images/favicon-book.png">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <title>Activities</title>
</head>
<style>
    h1 {
        padding: 15px;
        background-color: #fbd17d;
        display: flex;
        justify-content: center;
    }

    h4 {
        color: white;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .main {
        padding: 20px;
    }

    .main img {
        width: 100%;
        height: 500px;
        object-fit: cover;
    }

    .card-img-top {
        height: 400px;
        object-fit: cover;
    }

    .center-screen {
        height: 10vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 10%;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .card {
        position: relative;
        overflow: hidden;
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0);
        z-index: 1;
        transition: background-color 0.3s ease;
    }

    .card:hover::before {
        background-color: rgba(0, 0, 0, 0.4);
    }

    .card .buttons {
        position: absolute;
        bottom: 50%;
        left: 50%;
        transform: translate(-50%, 50%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2;
    }

    .card:hover .buttons {
        opacity: 1;
    }
</style>
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
                                    <button type="submit" class="btn btn-primary" name="addToRoutineBtn">Add to Morning Routine</button>
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

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
    </script>
</body>

</html>