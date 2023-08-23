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

// Medal function
function medalImage($userPoints) {
    if ($userPoints <= 1000) {
        return "../pictures-medal/bronce-medal.png";
    } elseif ($userPoints <= 2000) {
        return "../pictures-medal/silver-medal.png";
    } elseif ($userPoints <= 3000) {
        return "../pictures-medal/gold-medal.png";
    } elseif ($userPoints <= 4000) {
        return "../pictures-medal/platin-medal.png";
    } else{
    return "../pictures-medal/diamond-medal.png";
}
}

function needPoints($userPoints) {
    $nextMedalPoints = 0;

    if ($userPoints <= 1000) {
        $nextMedalPoints = 1000 - $userPoints;
    } elseif ($userPoints <= 2000) {
        $nextMedalPoints = 2000 - $userPoints;
    } elseif ($userPoints <= 3000) {
        $nextMedalPoints = 3000 - $userPoints;
    } elseif ($userPoints <= 4000) {
        $nextMedalPoints = 4000 - $userPoints;
    }
    return $nextMedalPoints;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- favicon link -->
    <link rel="icon" type="pictures/png" href="pictures/logo.png">

    <!-- Icon Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="../index.css">
    <link rel="stylesheet" href="crud_user.css">

    <title>Your Profile</title>
</head>

<body>


    <!-- Navbar -->
    <?php echo $navbar ?>

    <h1 class="text-center" style="padding:25px 0px">Profile</h1>

    <section class="mySection mb-5">
        <div class="container h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="profile-image col-md-8 col-lg-7 col-xl-6 showLeft">
                    <img src='../pictures/<?php echo $row["user_picture"] ?>' class='img-fluid detailsImage imageShow' alt='User Picture' style="max-height: 700px">
                </div>
                <div class="profile-info col-md-7 col-lg-5 col-xl-5 offset-xl-1 showRight">
                   <img src="<?php echo medalImage($row['user_points']); ?>" alt="medal" class="medal">

                    <form>
                        <h3 class="mb-4">Welcome <?php echo $row["fname"] ?> <?php echo $row["lname"] ?></h3>
                        <hr>
                        <p><span><strong>Username:</strong></span> <?php echo $row["username"] ?></p>
                        <p><span><strong>Email:</strong></span> <?php echo $row["email"] ?></p>
                        <p><span><strong>Total points:</strong></span> <?php echo $row["user_points"] ?></p>
                        <p style="font-size: 10px;"><span><strong></strong></span> You need<?php echo needPoints($row['user_points']); ?> points for next badge.</p>
                        <p><span><strong>Routine <i class="fa-regular fa-circle-check"></i></strong></span> <?php echo $row["routine_done"] ?> times</p>
                        <hr>
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