<?php
// Start a session (if not already started)
session_start();

// Redirect to the dashboard if an admin is logged in
if (isset($_SESSION["adm"])) {
    header("Location: ../dashboard.php");
}

// Redirect to the index page if a regular user is logged in
if (isset($_SESSION["user"])) {
    header("Location: ../index.php");
}

// Include the database connection file
require_once "../components/db_connect.php";

// Include the file_upload function
require_once "../components/file_upload.php";

// Initialize error flags and variables
$error = false;
$fname = $lname = $username = $email = "";
$fname_error = $lname_error = $username_error = $email_error = $password_error = "";

// Function to clean and sanitize user input
function cleanInput($param)
{
    $data = trim($param);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}

// Check if the "sign-up" form is submitted
if (isset($_POST["sign-up"])) {

    // Clean and sanitize user inputs
    $fname = cleanInput($_POST["fname"]);
    $lname = cleanInput($_POST["lname"]);
    $username = cleanInput($_POST["username"]);
    $email = cleanInput($_POST["email"]);
    $password = $_POST["password"]; // No cleaning for passwords, as special characters are allowed
    $picture = fileUpload($_FILES["picture"]); // Use the file_upload function to handle file uploads

    // Validation for first name
    if (empty($fname)) {
        $error = true;
        $fname_error = "Please enter your first name!";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $fname_error = "Name must have at least 3 characters";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $fname_error = "Name must contain only letters and spaces.";
    }

    // Validation for last name
    if (empty($lname)) {
        $error = true;
        $lname_error = "Please enter your last name";
    } elseif (strlen($lname) < 3) {
        $error = true;
        $lname_error = "Name must have at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $lname_error = "Name must contain only letters and spaces.";
    }

    // Validation for username
    if (empty($username)) {
        $error = true;
        $username_error = "Please enter your username";
    } elseif (strlen($username) < 7) {
        $error = true;
        $username_error = "Username must have at least 7 characters.";
    }

    // Validation for email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Please enter a valid email address";
    } else {
        // Check if the email is already in use
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $email_error = "Provided Email is already in use";
        }
    }

    // Validation for password
    if (empty($password)) {
        $error = true;
        $password_error = "Password can't be empty!";
    } elseif (strlen($password) < 6) {
        $error = true;
        $password_error = "Password must have at least 6 characters.";
    }

    // If there are no validation errors, insert the user data into the database
    if (!$error) {
        $password = hash("sha256", $password); // Hash the password
        $sql = "INSERT INTO `users`(`fname`, `lname`, `username`, `email`, `user_picture`, `password`) VALUES ('$fname','$lname','$username','$email','$picture[0]', '$password')";
        $result = mysqli_query($connect, $sql);

        if ($result) {
            echo   "<div class='alert alert-success'>
               <p>New account has been created, you can login now! $picture[1]</p>
                </div>";
            header("Location: login.php");
        } else {
            echo "<div class='alert alert-danger'>
                <p>Something went wrong, please try again later ...</p>
                </div>";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
    <title>Sign up</title>
</head>

<body>

    <section class="mySection">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6 leftRegister">
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3 mt-3">
                            <label for="fname" class="form-label">First name:</label>
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?= $fname ?>">
                            <span class="text-danger"><?= $fname_error ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="lname" class="form-label">Last name:</label>
                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" value="<?= $lname ?>">
                            <span class="text-danger"><?= $lname_error ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $username ?>">
                            <span class="text-danger"><?= $username_error ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address">
                            <span class="text-danger" id="emailStatus"><?= $email_error ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="picture" class="form-label">Profile picture:</label>
                            <input type="file" class="form-control" id="picture" name="picture">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Type your password">
                            <span class="text-danger"><?= $password_error ?></span>
                        </div>
                        <button name="sign-up" type="submit" class="btn mt-3 myBtn">Create account</button>
                        <br>
                        <br>
                    </form>
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 rightRegister">
                    <h1 class="mt-5">Welcome to your morning routine planner!</h1>
                    <br>
                    <h5>To login, please register first!</h5>
                    <br>
                    <span>You already have an account? <br><br> <a href="login.php">login here</a></span>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>