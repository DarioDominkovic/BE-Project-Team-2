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
    WHERE ra.fk_users = $user_id
    ORDER BY ra.activity_order";

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
            $totalPoints += $row['activity_points'];
            $totalTime += $row['duration'];
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
                        
                        <!-- Form to update activity order -->
                        <form method="post" action="update_activity_order.php" class="d-flex justify-content-center align-items-center">
                            <input type="hidden" name="activity_id" value="' . $row['id'] . '">
                            <button type="submit" name="increaseOrder" class="btn btn-primary mx-1">+</button>
                            <h3 class="text-center mx-2">' . $row['activity_order'] . '</h3>
                            <button type="submit" name="decreaseOrder" class="btn btn-danger mx-1">-</button>
                        </form>
                          
                        <a class="d-block mt-3 justify-content-center text-center rounded-pill text-uppercase" href="routine.php?deleteRoutine=true&id=' . $row['id'] . '" class="btn ms-2">Delete</a>
                    </div>
                </div>
            </div>';
        }
    } else {
        echo '<div class="col text-center"><p>- No routine found -</p></div>';
    }

?>
<div class="container hello">
    <div class="row total-container">
        <div class="total-info col-md-6">
                <h1 class="text-center">Total</h1>
                <br>
                <h3><i class="fa-regular fa-star" style="color: #ffff00;"></i>&nbsp&nbsp<?php echo $totalPoints; ?> Points</h3>
                <br>
                <h3><i class="fa-regular fa-clock" style="color: darkgrey;"></i>&nbsp;&nbsp;<span id="initialTime"><?php echo $totalTime; ?></span> Minutes</h3>
            </div>
        
            <div class="total-timer col-md-6">
                <h3 class="text-center">Timer</h3>
                <div id="activityName"></div>
                <div id="input" hidden><?php echo implode(',', $activityNames); ?></div>
                <div id="input2" hidden><?php echo implode(',', $activityTimes); ?></div>
                <div id="input3" hidden><?php echo $totalPoints ?></div>
                <div class="py-2" id="output"></div>
                <p><span id="remainingTime"><?php echo $totalTime; ?> Minutes</span></p>
                <button id="startButton">Start Timer</button>
                <br><br>
                <button id="stopButton">Stop Timer</button>
            </div>
        </div>
    </div>
</div>
    
<script>    
    var totalMinutes = <?php echo $totalTime; ?>;
    var totmin = totalMinutes;
    var totalTimeInSeconds = totalMinutes * 60;
    var remainingTimeElement = document.getElementById("remainingTime");
    var activityNameElement = document.getElementById("activityName");
    var intervalId;

    const out = document.getElementById("output");
    const input = document.getElementById("input");
    const activityNames = input.innerHTML.split(',');
    const input2 = document.getElementById("input2");
    const activityTimes = input2.innerHTML.split(',');
    let totalpoints = document.getElementById("input3").innerHTML;
    totalpoints = Number(totalpoints);


    function updateTimer() {
        var minutes = Math.floor(totalTimeInSeconds / 60);
        var seconds = totalTimeInSeconds % 60;
        
        if(minutes < totmin - Number(activityTimes[0])){
            totmin -= Number(activityTimes[0]);
            activityNames.shift();
            activityTimes.shift();
            out.innerHTML = activityNames[0];
        }
        else{
            out.innerHTML = activityNames[0];
        }
        
        remainingTimeElement.textContent = minutes + "m " + seconds + "s";
        
        if (totalTimeInSeconds <= 0) {
            clearInterval(intervalId);
            remainingTimeElement.textContent = "Time's up!";
            activityNameElement.textContent = "Activity Completed";
            let xhr = new XMLHttpRequest ;
            xhr.open("get", `update_userpoints.php?newpoints=${totalpoints}`);
            xhr.onload = function(){
                console.log(this.responseText);
            };
            xhr.send();

        } else {
            totalTimeInSeconds--;
        }
    }

    document.getElementById("startButton").addEventListener("click", function() {
        intervalId = setInterval(updateTimer, 10);
    });

    document.getElementById("stopButton").addEventListener("click", function() {
        clearInterval(intervalId);
        remainingTimeElement.textContent = "STOP";
        activityNameElement.textContent = "Activity Stopped";
    });
</script>

</body>

</html>


