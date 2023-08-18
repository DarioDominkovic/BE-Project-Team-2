<?php
session_start();
require_once "components/db_connect.php";

$raus = "../";
$rein = "";
require_once "components/navbar.php";

// Fetch activities from the database
$sql = "SELECT * FROM activity";
$result = mysqli_query($connect, $sql);

// Handle routine creation
if (isset($_POST["create_routine"])) {
    // Get selected activity IDs from the form
    $selectedActivities = $_POST["activities"];

    //    here we have to perform further actions and link it like updating the DB to creae routine 
    //  as we need a new button on our index (Add to my routine).. this button should be adding the predefined activity to the new created routine
}

?>

<!DOCTYPE html>
<html lang="en">
<!-- our HTML head content should be here -->

<body>
    <?php echo $navbar ?>

    <div class="container mt-5">
        <h2>Create New Routine</h2>
        <form method="POST">
            <div class="mb-3 mt-3">
                <label for="activities" class="form-label">Select Activities</label>
                <select class="form-select" id="activities" name="activities[]" multiple>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button name="create_routine" type="submit" class="btn btn-outline-primary">CREATE ROUTINE</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>