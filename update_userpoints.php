<?php
session_start();
require_once "components/db_connect.php"; // Make sure this file includes the database connection

$newpoints = $_GET["newpoints"];

$sql = "SELECT user_points, routine_done FROM users WHERE id = $_SESSION[user]";

$result = mysqli_query($connect, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $points = $row["user_points"];
    $routineDone = $row["routine_done"];

    $sum = $points + $newpoints;

    $sqlUpdatePoints = "UPDATE users SET user_points = $sum WHERE id = $_SESSION[user]";

    if (mysqli_query($connect, $sqlUpdatePoints)) {
        // Update routine_done column
        $sqlUpdateRoutine = "UPDATE users SET routine_done = routine_done + 1 WHERE id = $_SESSION[user]";
        if (mysqli_query($connect, $sqlUpdateRoutine)) {
            echo "Points updated successfully.";
        } else {
            echo "Error updating routine_done: " . mysqli_error($connect);
        }
    } else {
        echo "Error updating user_points: " . mysqli_error($connect);
    }
} else {
    echo "Error retrieving user data: " . mysqli_error($connect);
}

mysqli_close($connect);
?>
