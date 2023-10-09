<?php
// Start a session (if not already started)
session_start();

// Include the database connection file
require_once "../components/db_connect.php";

// Redirect to the dashboard if an admin is logged in
if (isset($_SESSION["adm"])) {
    header("Location: ../dashboard.php");
}

// Redirect to the index page if a regular user is logged in
if (isset($_SESSION["user"])) {
    header("Location: ../index.php");
}

// Initialize variables for email, username, and error messages
$email = $username = $password_error = $email_error = $username_error = "";
$error = false;

// Function to clean and sanitize user input
function cleanInputs($input)
{
    $data = trim($input);                    // Remove extra spaces, tabs, newlines from the string
    $data = strip_tags($data);              // Remove HTML tags from the string
    $data = htmlspecialchars($data);        // Convert special characters to HTML entities (e.g., "<" becomes "&lt;")

    return $data;
}

// Check if the "login" form is submitted
if (isset($_POST["login"])) {
    // Clean and sanitize user inputs
    $email = cleanInputs($_POST["email"]);
    $username = cleanInputs($_POST["username"]);
    $password = $_POST["password"];

    // Validate that either email or username is provided
    if (empty($email) && empty($username)) {
        $error = true;
        $username_error = "Email or username is required!";
    }

    // Validate email format (if provided)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
        $error = true;
        $email_error = "Please enter a valid email address";
    }

    // Validate that the password is not empty
    if (empty($password)) {
        $error = true;
        $password_error = "Password can't be empty!";
    }

    // If there are no validation errors, proceed to database query
    if (!$error) {
        // Hash the password for comparison with the stored hashed password
        $password = hash("sha256", $password);
        $sql = "SELECT * FROM users WHERE (email = '$email' OR username = '$username') AND password = '$password'";

        // Execute the SQL query
        $result = mysqli_query($connect, $sql);
        $row = mysqli_fetch_assoc($result);

        // Check if there is exactly one matching user
        if (mysqli_num_rows($result) == 1) {
            if ($row["status"] == "user") {
                // Set session variable for regular user and redirect
                $_SESSION["user"] = $row["id"];
                header("Location: ../index.php");
            } else {
                // Set session variable for admin user and redirect
                $_SESSION["adm"] = $row["id"];
                header("Location: ../dashboard.php");
            }
        } else {
            // Display an error message if login credentials are incorrect
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
                    <a href="register.php" class="btn mt-3 myBtn">Register here</a></span>
                    <br> <br>
                    <a href="forgotpassword.php" class="btn mt-3 myBtn">Forgot my password</a></span>
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

                        <button name="login" type="submit" class="btn mt-3 myBtn">Login</button>
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