<?php
session_start();
require_once "../components/db_connect.php";
require_once "../components/file_upload.php";

$id = $_GET["id"];

if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    $delete = "DELETE FROM `activity` WHERE id = $id";
    
    require_once "../components/db_connect.php"; // Reopen the connection before executing the delete query
    
    if(mysqli_query($connect, $delete)){
        mysqli_close($connect); // Close the connection after the delete query
        header("Location:../index.php");
        exit();
    } else {
        echo "Error";   
    }
}

$sql = "SELECT * FROM `activity` WHERE id = $id";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
mysqli_close($connect);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            width: 300px;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Display the photo using an <img> tag -->
        <img src="../pictures/<?php echo $row["activity_picture"]; ?>" alt="<?php echo $row["name"]; ?>" width="200" height="200">
        <h2>Delete Confirmation</h2>
        <p>Are you sure you want to delete this record?</p>
        
        <p>
            <a href="delete.php?id=<?php echo $id; ?>&confirm=yes" class="btn btn-outline-danger">Yes</a>
            <a href="../index.php" class="btn btn-outline-primary">No</a>
        </p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
