<?php 
session_start();
require_once "../components/db_connect.php";

$row = [];
if (isset($_GET["x"])) {
  $id = $_GET["x"];
$sql = "SELECT * FROM `animal` WHERE id = $id";
$result = mysqli_query($connect,$sql);
$row = mysqli_fetch_assoc($result);
}
?>;

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
 <div class="container">
    <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-1">
      <div>
      
      <div class="card" style="width: 18rem;">
      
  <div class="card-body">
    <h5 class="card-title"><p>Name: <?= isset($row["name"]) ? $row["name"] : "" ?></p></h5>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item"><p>Duration: <?= isset($row["duration"]) ? $row["duration"] : "" ?></p></li>
    <li class="list-group-item"><p>Status: <?= isset($row["status"]) ? $row["status"] : "" ?></p></li>
    <li class="list-group-item"><p>Activity_Points: <?= isset($row["activity_points"]) ? $row["activity_points"] : "" ?></p></li>
    <li class="list-group-item"><p>Activity_Order: <?= isset($row["activity_order"]) ? $row["activity_order"] : "" ?></p></li>
</li>
  </ul>
  <div>
  <a href='index.php?x={$row["id"]}' class='btn btn-success'>Back to Activities</a>
  </div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>