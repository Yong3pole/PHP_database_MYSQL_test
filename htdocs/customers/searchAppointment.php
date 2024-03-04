<?php
// Include the database connection file (e.g., connect.php)
include 'connect.php';

// Check if the search query is submitted
if (isset($_POST['customer_name'])) {
    $customerName = $_POST['customer_name'];

    // Search for the customer in the owners table
    $sql = "SELECT OwnerID FROM owners WHERE cname = ?";
    $stmt = mysqli_stmt_init($con);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $customerName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $customer = mysqli_fetch_assoc($result);

        if ($customer) {
            // Customer found, search for appointments in the appointments table
            $sql = "SELECT * FROM appointments WHERE OwnerID = ?";
            $stmt = mysqli_stmt_init($con);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 's', $customer['OwnerID']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                // Prepare the appointment details for JSON response
                $appointments = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    $appointments[] = $row;
                }

                // Return the appointments as JSON
                echo json_encode($appointments);
            }
        } else {
            echo json_encode(array()); // Return an empty array if no appointments are found
        }
    }
}
?>