<?php
session_start();
require_once "../components/db_connect.php";
require_once "../components/navbar.php";

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
}

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

    <!-- favicon link -->
    <link rel="icon" type="pictures/png" href="pictures/logo.png">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="show.css">

    <title>Your Profile</title>
</head>

<body>


    <!-- Navbar -->
    <?php echo $navbar ?>

    <h1 class="text-center" style="padding:25px 0px">Profile</h1>

    <section class="mySection py-5">
        <div class="container h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="profile-image col-md-8 col-lg-7 col-xl-6 showLeft">
                    <img src='../pictures/<?php echo $row["user_picture"] ?>' class='img-fluid detailsImage imageShow' alt='User Picture' style="max-height: 700px">
                </div>
                <div class="profile-info col-md-7 col-lg-5 col-xl-5 offset-xl-1 showRight">
                    <img src="../pictures/medal.png" alt="Medal" class="medal">
                    <form>
                        <h3 class="mb-4">Welcome to your account,</h3>
                        <h3><?php echo $row["fname"] ?> <?php echo $row["lname"] ?></h3>
                        <hr>
                        <h4 class="mt-4 mb-4">Check out your data:</h4>
                        <p><span><strong>Username:</strong></span> <?php echo $row["username"] ?></p>
                        <p><span><strong>Email:</strong></span> <?php echo $row["email"] ?></p>
                        <p><span><strong>Total points:</strong></span> <?php echo $row["user_points"] ?></p>
                        <hr>
                        <p>Not correct? Change it!</p>
                        <br><br>
                        <p><a href="../index.php" class="btn myBtn">Back to activities</a></p>
                        <p><a href="../login/resetpassword.php" class="btn myBtn">Reset password</a></p>
                        <p><a href="update.php?id" class="btn myBtn">Update account</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>