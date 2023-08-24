<?php
session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

$num = 0;
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

    <title>Achievements</title>
</head>

<body>
    <?php echo $navbar ?>

    <h1 class="text-center" style="padding-top: 25px;">Achievements</h1>

    <h5 class="text-center" style="color:grey; padding-bottom: 25px;">Here you can see how often youve done your activities</h5>

    <table class="table">
        <tbody>
            <?php
            $sql = "SELECT aud.*, a.name AS activity_name FROM activity_user_done aud
                    JOIN activity a ON aud.fk_activity = a.id";
            $result = $connect->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $num = $row['Done'];
                    $format = 10;
                    if ($num <= 10) {
                         
                        $format =10;
                    };
                    
                    if ($row['Done'] > 10) {
                        $format = 100; 

                    }
                    if ($row['Done'] > 100) {
                        $format = 1000; 

                    }
                    $num = $num * 100 / $format;
                    echo "<div class='container' style='padding-bottom: 25px;'> ";
                    echo "<div class='progress-container' style='background-color:#455d7a; color:#e3e3e3; padding: 20px; border: 5px solid #233142 ;border-radius: 20px;'>";
            
                    echo "<div class='row'>";
                    echo "<div class='col-md-6'>";
                    echo "<h3>" . $row["activity_name"] . "</h3>";
                    echo "</div>";
                    echo "<div class='col-md-6'>";
                    echo "<p class='text-end'> $format times</p>";
                    echo "</div>";
                    echo "</div>";
            
                    echo "<div class='progress'>";
                    echo "<div class='progress-bar' role='progressbar' style='width:" . $num . "%; background-color: #f95959;' aria-valuenow='" . $num . "' aria-valuemin='0' aria-valuemax='100'>" . $num . "%</div>";
                    echo "</div>";
            
                    echo "</div></div>";
                }
            }
             else {
                echo "<tr><td colspan='2'>No activities found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
