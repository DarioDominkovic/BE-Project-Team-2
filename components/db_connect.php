<?php

    $localhost = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "morning_routine_manager";

    // create connection
    $connect = mysqli_connect($localhost, $username, $password, $dbname);

    // check connection
    if (!$connect) {
        die ("connection failed");
    }

?>