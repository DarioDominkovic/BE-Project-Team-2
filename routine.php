<?php
session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

$totalPoints = 0;
$totalTime = 0;
$activityNames = [];
$activityTimes = [];

$user_id = $_SESSION['user'];
$routine_activities_query = "SELECT a.*, ra.* FROM `activity` a
    JOIN `routine_activity` ra ON a.id = ra.fk_activity
    WHERE ra.fk_users = $user_id";
$routine_activities_result = mysqli_query($connect, $routine_activities_query);

if (isset($_GET['deleteRoutine']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete = "DELETE FROM `routine_activity` WHERE id = $id";

    if (mysqli_query($connect, $delete)) {
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
    
    <!-- CSS LINK -->
    <link rel="stylesheet" href="index.css">

    <!-- FONT AWESOME ICONS LINK  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <title>My Routine</title>
</head>

<body>
    <!-- Navbar start-->
    <?php echo $navbar ?>
    <!-- Navbar end-->

    <h1 class="text-center" style="padding: 25px 0px">My Routine</h1>

    <?php
    
    if (mysqli_num_rows($routine_activities_result) > 0) {
        while ($row = mysqli_fetch_assoc($routine_activities_result)) {

        $totalPoints += $row['activity_points']; // Add activity points to the  total
        
        $totalTime += $row['duration']; // Add activity points to the total
        $activityTimes[] = $row['duration'];
        $activityNames[] = $row['name'];
        
        echo '<div class="index-card-container">
            <div class="index-card-2">       
                <div class="index-card-image">';
        if (!empty($row['activity_picture'])) {
            if (filter_var($row['activity_picture'], FILTER_VALIDATE_URL)) {
                echo '<img src="' . $row['activity_picture'] . '" class="card-img-top" alt="' . $row['name'] . '">';
            } else {
                echo '<img src="pictures/' . $row['activity_picture'] . '" class="card-img-top" alt="' . $row['name'] . '">';
            }
        } else {
            echo '<img src="default-image.jpg" class="card-img-top" alt="' . $row['name'] . '">';
        }
        echo '</div>
                <div class="index-card-description">
                    <h3 class="text-center">' . $row['name'] . '</h3>
                    <h3 class="text-center"><i class="fa-regular fa-clock" style="color: darkgrey;"></i> &nbsp;&nbsp;' . $row['duration']. '&nbsp;min </h3>
                    <h3 class="text-center"><i class="fa-regular fa-star" style="color: #ffff00;"></i>&nbsp;&nbsp;' . $row['activity_points'] . '&nbsp;Points</h3>    
                    <a class="d-block mt-3 justify-content-center text-center rounded-pill text-uppercase" href="routine.php?deleteRoutine=true&id=' . $row['id'] . '" class="btn ms-2">Delete</a>
                </div>
            </div>
        </div>';
    }
} else {
    echo '<div class="col"><p>Media not found.</p></div>';
}
?>
    <div class="text-center">
        <h3><i class="fa-regular fa-star" style="color: #ffff00;"></i>&nbsp&nbsp<?php echo $totalPoints; ?> Points</h3>
    </div>
    
    <div class="text-center">
    <h3><i class="fa-regular fa-clock" style="color: darkgrey;"></i>&nbsp;&nbsp;<span id="initialTime"><?php echo $totalTime; ?></span> Minutes</h3>
    <button id="startButton">Start Timer</button>
    <button id="stopButton">Stop Timer</button>
    <p>Remaining Time: <span id="remainingTime"><?php echo $totalTime; ?></span> Minutes</p>
    <div id="output"></div>
    <div id="input" hidden><?php echo implode(',', $activityNames); ?></div>
    <div id="input2" hidden><?php echo implode(',', $activityTimes); ?></div>
</div>

<script>    
    var totalMinutes = <?php echo $totalTime; ?>;
    var totalTimeInSeconds = totalMinutes * 60; // Convert minutes to seconds
    var remainingTimeElement = document.getElementById("remainingTime");
    var activityNameElement = document.getElementById("activityName");
    var intervalId;

    const out = document.getElementById("output");
    const input = document.getElementById("input");
    const activityNames = input.innerHTML.split(',');
    const input2 = document.getElementById("input2");
    const activityTimes = input2.innerHTML.split(',');

    function updateTimer() {
        var minutes = Math.floor(totalTimeInSeconds / 60);
        var seconds = totalTimeInSeconds % 60;
        
        if(minutes < totalMinutes - Number(activityTimes[0])){
            activityNames.shift();
            activityTimes.shift();
// was anderes
        }
        else{
            out.innerHTML = activityNames[0];

        }
        
        remainingTimeElement.textContent = minutes + "m " + seconds + "s";
        
        if (totalTimeInSeconds <= 0) {
            clearInterval(intervalId);
            remainingTimeElement.textContent = "Time's up!";
            activityNameElement.textContent = "Activity Completed";
        } else {
            totalTimeInSeconds--;
        }
    }

    document.getElementById("startButton").addEventListener("click", function() {
        intervalId = setInterval(updateTimer, 1000);
    });

    document.getElementById("stopButton").addEventListener("click", function() {
        clearInterval(intervalId);
        remainingTimeElement.textContent = totalMinutes + " Minutes";
        activityNameElement.textContent = "Activity Stopped";
    });
</script>

</body>

</html>


