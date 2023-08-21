<?php
session_start();
require_once "components/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $routineName = $_POST["routineName"];
    $routineDescription = "Description of the routine";
    $user_id = $_SESSION['user'];

    $sql = "INSERT INTO `routine`(`routine_name`, `description`) VALUES (?, ?)";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $routineName, $routineDescription);
    if (mysqli_stmt_execute($stmt)) {
        $last_id = mysqli_insert_id($connect);
        mysqli_query($connect, "INSERT INTO `routine_activity`(`fk_activity`, `fk_routine`, `fk_users`) VALUES (null, $last_id, $user_id)");
        //success massage? or just redirect?????
        header("Location: routine.php");
        exit;
    } else {
        echo "Error creating routine: " . mysqli_error($connect);
    }

    mysqli_stmt_close($stmt);
}
?>