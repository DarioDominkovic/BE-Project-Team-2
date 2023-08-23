<?php
session_start();
require_once "components/db_connect.php";

if (isset($_POST['activity_id'])) {
    $activity_id = $_POST['activity_id'];

    if (isset($_POST['increaseOrder'])) {
        // Update the activity order by increasing it by 1
        $update_query = "UPDATE `routine_activity` SET `activity_order` = `activity_order` + 1 WHERE `id` = $activity_id";
    } elseif (isset($_POST['decreaseOrder'])) {
        // Update the activity order by decreasing it by 1
        $update_query = "UPDATE `routine_activity` SET `activity_order` = `activity_order` - 1 WHERE `id` = $activity_id";
    }

    if (isset($update_query)) {
        if (mysqli_query($connect, $update_query)) {
            mysqli_close($connect);
            header('location: routine.php'); // Redirect back to the routine page after updating
        } else {
            echo "Error updating activity order: " . mysqli_error($connect);
        }
    }
}
?>
