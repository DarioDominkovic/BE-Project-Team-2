<?php
session_start();
require_once "../components/db_connect.php";
require_once "../components/file_upload.php";

$id = $_GET["id"];

if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    $delete = "DELETE FROM `activity` WHERE id = $id";
    
    require_once "../components/db_connect.php";
    
    if(mysqli_query($connect, $delete)){
        mysqli_close($connect);
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
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        :root {
            --one: #233142;
            --two: #455d7a;
            --three: #f95959;
            --black: #1d1d1d ;
            --white: #e3e3e3;
        }

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
        .myBtn {
            background-color: var(--one) !important;
            color: #F5F5F5;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .myBtn:hover {
            background-color: var(--three) !important;
            color: var(--white);
        }
    </style>
</head>
<body>
    <div class="card">
        <!-- Display the photo using an <img> tag -->
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
        <h2>Delete Confirmation</h2>
        <p>Are you sure you want to delete this record?</p>
        
        <p>
            <a href="delete.php?id=<?php echo $id; ?>&confirm=yes" class="btn myBtn">Yes</a>
            <a href="../index.php" class="btn myBtn">No</a>
        </p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
