<?php
    require_once "../components/db_connect.php";
    
    $id = $_GET["id"]; // to take the value from the parameter "id" in the url 
    $sql = "SELECT * FROM `activity` WHERE id = $id"; // finding the product 
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($result);  // fetching the data 
    mysqli_close($connect);

    if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        if($row["picture"] != "product.png"){ // if the picture is not product.png (the default picture) we will delete the picture
            unlink("pictures/" . $row["picture"]);
        }
        
        $delete = "DELETE FROM `activity` WHERE id = $id"; // query to delete a record from the database

        require_once "../components/db_connect.php"; // Reopen the connection before executing the delete query

        if(mysqli_query($connect, $delete)){
            header("Location: ../index.php");
        } else {
            echo "Error";
        }

        mysqli_close($connect);
    }
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
            <a href="../dashboard.php" class="btn btn-outline-primary">No</a>
        </p>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>
