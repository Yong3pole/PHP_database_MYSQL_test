<?php
include 'connect.php';

// Check if OwnerID is set and not empty
if (isset($_POST['OwnerID']) && !empty($_POST['OwnerID'])) {
    $OwnerID = $_POST['OwnerID'];
    // Fetch pets for selected owner
    $sql = "SELECT * FROM animals WHERE OwnerID = ?";
    $stmt = mysqli_stmt_init($con);
    // Prepare the SQL statement
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("SQL error");
    } else {
        // Bind parameters to the placeholder
        mysqli_stmt_bind_param($stmt, "s", $OwnerID);
        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
        // Get result
        $result = mysqli_stmt_get_result($stmt);
        // Fetch data from database and output it as JSON
        $pets = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $pets[$row['AnimalID']] = $row['AnimalName'];
        }
        // If no pets found, return specific message
        if (empty($pets)) {
            echo json_encode(array('message' => 'No pets found'));
        } else {
            echo json_encode($pets);
        }
    }
}
?>
