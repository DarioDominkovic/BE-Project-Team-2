<?php
// Including the database connection file
require_once "../db_connect.php";

// Getting the 'id' parameter from the URL using GET method
$id = $_GET["x"];

// Check if the 'id' parameter is provided and it is a number
if (!isset($id) || !is_numeric($id)) {
  echo "Invalid ID";
  exit; // Terminate the script
}

// Query to fetch the record with the specified 'id' from the database
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($connect, $sql);

// Check if a row is found with the given 'id'
if (!$row = mysqli_fetch_assoc($result)) {
  echo "Record not found";
  exit; // Terminate the script
}

// Check if the delete action is confirmed by the user
if (isset($_GET["confirm"]) && $_GET["confirm"] === "yes") {
  // Preparing the DELETE query to remove the record with the specified 'id'
  $delete = "DELETE FROM `users` WHERE id = $id";

  // Executing the DELETE query
  if (mysqli_query($connect, $delete)) {
    // If the deletion is successful, redirect the user to the dashboard.php page
    header("Location: dashboard.php");
    exit; // Terminate the script to prevent further execution
  } else {
    // If an error occurs during deletion, display the error message
    echo "Error deleting record: " . mysqli_error($connect);
    exit; // Terminate the script
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Delete Confirmation</title>
</head>

<body>
  <h2>Delete Confirmation</h2>
  <p>Are you sure you want to delete this user</p>
  <!-- Display the photo using an <img> tag -->
  <img src="../pictures/<?php echo $row["image"]; ?>" alt="<?php echo $row["title"]; ?>" width="200" height="200">
  <p>
    <a href="delete.php?x=<?php echo $id; ?>&confirm=yes">Yes</a> |
    <a href="dashboard.php">No</a>
  </p>
</body>

</html>