<?php

session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

$user_id = $_SESSION['user'];

$sql_user_routines = "SELECT DISTINCT r.id, r.routine_name 
FROM routine r
JOIN routine_activity ra ON r.id = ra.fk_routine
WHERE ra.fk_users = ?";
$stmt = mysqli_prepare($connect, $sql_user_routines);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result_user_routines = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    
    <!-- CSS link 
    <link rel="stylesheet" href="index.css">
    -->
    
    

    <title>Morning Routine</title>
</head>

<body>
    <?php echo $navbar ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title">Create New Routine</h3>
                        <form method="post" action="create_routine.php">
                            <div class="mb-3">
                                <label for="routineName" class="form-label">Routine Name</label>
                                <input type="text" class="form-control" id="routineName" name="routineName" required>
                            </div>
                            <div class="mb-3">
                                <label for="routineDescription" class="form-label">Routine Description</label>
                                <input type="text" class="form-control" id="routineDescription" name="routineDescription" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create Routine</button>
                        </form>
                    </div>
                </div>
            </div>

            


        </div>

        <?php

            if (mysqli_num_rows($result_user_routines) > 0) {
                while ($row = mysqli_fetch_assoc($result_user_routines)) {
            ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <a href="routine_activities.php?routine_id=<?php echo $row['id']; ?>">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $row['routine_name']; ?></h3>
                                </div>
                            </a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<div class="col"><p>No routines found.</p></div>';
            }
            ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>


