<?php
session_start();
require_once "components/db_connect.php";

if (isset($_POST['activity_id'])) {
    $activity_id = $_POST['activity_id'];
    $result = mysqli_query($connect,"SELECT * FROM routine_activity WHERE id = $activity_id" );
    $row = mysqli_fetch_assoc($result);
    if (isset($_POST['increaseOrder'])) {

        // Update the activity order by increasing it by 1
        $add = $row["activity_order"] + 1;
        $update_query = "UPDATE `routine_activity` SET `activity_order` = `activity_order` + 1 WHERE `id` = $activity_id";
        $test = "UPDATE `routine_activity` SET `activity_order` = `activity_order` - 1 WHERE `id` != $activity_id AND activity_order = $add";
    } elseif (isset($_POST['decreaseOrder'])) {

        // Update the activity order by decreasing it by 1
        $sub = $row["activity_order"] - 1;
        $update_query = "UPDATE `routine_activity` SET `activity_order` = `activity_order` - 1 WHERE `id` = $activity_id";
        $test = "UPDATE `routine_activity` SET `activity_order` = `activity_order` + 1 WHERE `id` != $activity_id AND activity_order = $sub";
    }

    if (isset($update_query)) {
        if (mysqli_query($connect, $update_query)) {
            mysqli_query($connect, $test);
            mysqli_close($connect);
            header('location: routine.php'); // Redirect back to the routine page after updating
        } else {
            echo "Error updating activity order: " . mysqli_error($connect);
        }
    }
}
?>
