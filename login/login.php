<?php

session_start();
require_once "../components/db_connect.php";

if (isset($_SESSION["adm"])) {
    header("Location: ../dashboard.php");
}
if (isset($_SESSION["user"])) {
    header("Location: ../index.php");
}

$email = $username = $password_error = $email_error = $username_error = "";
$error = false;

function cleanInputs($input)
{
    $data = trim($input);                    // removing extra spaces, tabs, newlines out of the string
    $data = strip_tags($data);              // removing tags from the string
    $data = htmlspecialchars($data);        // converting special characters to HTML entities, something like "<" and ">", it will be replaced by "&lt;" and "&gt";

    return $data;
}

if (isset($_POST["login"])) {
    $email = cleanInputs($_POST["email"]);
    $username = cleanInputs($_POST["username"]);
    $password = $_POST["password"];

    if (empty($email) && empty($username)) {
        $error = true;
        $username_error = "Email or username is required!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {             // if the provided text is not a format of an email, error will be true
        $error = true;
        $email_error = "Please enter a valid email address";
    }
    // simple validation for the "password"
    if (empty($password)) {
        $error = true;
        $password_error = "Password can't be empty!";
    }

    if (!$error) {
        $password = hash("sha256", $password);
        $sql = "SELECT * FROM users WHERE (email = '$email' OR username = '$username') AND password = '$password'";

        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) == 1) {
            if ($row["status"] == "user") {
                $_SESSION["user"] = $row["id"];
                header("Location: ../index.php");
            } else {
                $_SESSION["adm"] = $row["id"];
                header("Location: ../dashboard.php");
            }
        } else {
            echo "<div class='alert alert-danger'>
                <p>Wrong credentials, please try again...</p>
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
    <title>Login</title>
</head>

<body>


    <section class=" mySection">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6 leftLogin">
                    <h1 class="mt-2 mr-2">Welcome to your morning routine! </h1>
                    <br>
                    <h5 class="pb-5">To see possible morning routines, please use the login on the right!</h5>
                    <span>You don't have an account yet? <br> <a href="register.php">register here</a></span>
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 rightLogin">
                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address: </label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?= $email ?>">
                            <span class="text-danger"><?= $email_error ?></span>
                        </div>

                        <p><strong>or</strong></p>

                        <div class="mb-3 mt-3">
                            <label for="username" class="form-label">Username: </label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= $username ?>">
                            <span class="text-danger"><?= $username_error ?></span>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password: </label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Type your password">
                            <span class="text-danger"><?= $password_error ?></span>
                        </div>

                        <button name="login" type="submit" class="btn btn-outline-secondary mt-3 myBtn">Login</button>
                        <br>
                        <br>

                    </form>
                </div>
            </div>
        </div>
    </section>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

</body>

</html>