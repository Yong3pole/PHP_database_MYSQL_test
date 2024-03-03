<?php
include 'connect.php';

// Check if the invoice ID is set in the query string
if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "DELETE FROM invoices WHERE InvoiceID = ?";
    $stmt = mysqli_prepare($con, $sql);

    // Bind the parameters
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the SQL statement
    mysqli_stmt_execute($stmt);

    // Check if the invoice was deleted successfully
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Redirect to invoices.php with a query parameter indicating success
        header('Location: invoices.php?delete_success=true');
        exit();
    } else {
        echo "Error deleting invoice: " . mysqli_error($con);
    }
} else {
    echo "Invoice ID not set.";
}
?>
