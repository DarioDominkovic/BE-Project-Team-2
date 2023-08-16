<?php

    session_start();


    if(!isset($_SESSION["user"]) && !isset($_SESSION["adm"])){
        header("Location: login.php");
    }

    require_once "components/db_connect.php";



    $id = $_GET["id"];

    $sql = "select * from `users` WHERE id=$id";
    
    $result = mysqli_query($connect, $sql);

    $row = mysqli_fetch_assoc($result);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

</head>
<body>



    <section class="mySection">
    <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
        <img src='pictures/<?php echo $row["user_picture"] ?>' class='img-fluid detailsImage' alt='media-cover' style='width: 50%; margin-left:100px;' >
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
            <form>
            <h3>Welcome to your account, </h3>
            <h3 class="mt-4"><?php echo $row["fname"] ?> <?php echo $row["lname"] ?></h3>
            <hr>
            <h4 class="mt-4 mb-4">Check out your data:</h4>
            <p>Username: <?php echo $row["username"] ?></p>
            <p>Email: <?php echo $row["email"] ?></p>
            <hr>
            <p>Not correct? Change it!</p>
            <p><a href="update_account.php?id=$id" class="btn btn-dark" style="width:100%">Update data</a></p>
            </form>
        </div>
        </div>
    </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
</body>
</html>