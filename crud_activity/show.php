<?php
session_start();
require_once "../components/db_connect.php";

$raus = "../";
$rein = "";
require_once "../components/navbar.php";

$row = [];
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $sql = "SELECT * FROM `activity` WHERE id = $id";
  $result = mysqli_query($connect, $sql);
  $row = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Activity Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

  <!-- CSS link -->
  <link rel="stylesheet" href="../index.css">
  <link rel="stylesheet" href="crud_activity.css">

</head>

<body>

  <?php echo $navbar ?>


  <section class="mySection py-5">
        <div class="container h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="profile-image col-md-8 col-lg-7 col-xl-6 showLeft">
                <?php
                if (!empty($row['activity_picture'])) {
                    if (filter_var($row['activity_picture'], FILTER_VALIDATE_URL)) {
                        echo '<img src="' . $row['activity_picture'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                    } else {
                        echo '<img src="pictures/' . $row['activity_picture'] . '" class="card-img-top" alt="' . $row['name'] . '">';
                    }
                } else {
                    echo '<img src="default-image.jpg"  class="card-img-top" alt="' . $row['name'] . '">';
                }
                ?>
                </div>
                <div class="profile-info col-md-7 col-lg-5 col-xl-5 offset-xl-1 showRight">
                    <form>
                        <h3 class="mb-4">Details of your choosen activity</h3>
                        <br>
                        <hr>
                        <br>
                        <p><span><strong>Name:</strong></span> <?= isset($row["name"]) ? $row["name"] : "" ?></p>
                        <p><span><strong>Duration:</strong></span> <?= isset($row["duration"]) ? $row["duration"] : "" ?></p>
                        <p><span><strong>Status:</strong></span> <?= ($row["status"] == 1) ? 'Done' : 'Not Done' ?></p>
                        <p><span><strong>Points:</strong></span> <?= isset($row["activity_points"]) ? $row["activity_points"] : "" ?></p>
                        <p><span><strong>Order:</strong></span> <?= isset($row["activity_order"]) ? $row["activity_order"] : "" ?></p>
                        <br>
                        <hr>
                        <br><br>
                        <p> <a href='../index.php' class='btn myBtn'>BACK TO ACTIVITY LIST</a></p>
                        <p><a href="../routine.php?id=<?php echo $row['id']; ?>" class="btn myBtn">ADD TO ROUTINE</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>