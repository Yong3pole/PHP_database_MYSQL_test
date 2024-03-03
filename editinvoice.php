<?php

include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM invoices WHERE InvoiceID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $InvoiceID = $row['InvoiceID'];
    $AppointmentID = $row['AppointmentID'];
    $ProcedureID = $row['ProcedureID'];
    $InvoiceDate = $row['InvoiceDate'];
    $TotalCost = $row['TotalCost'];
    $Status = $row['Status'];
}

if (isset($_POST['update_invoice'])) {
    // Retrieve form data
    $InvoiceID = $_POST['InvoiceID'];
    $AppointmentID = $_POST['AppointmentID'];
    $ProcedureID = $_POST['ProcedureID'];
    $InvoiceDate = $_POST['InvoiceDate'];
    $Status = $_POST['Status'];

    // Get ProcedureCost from procedures table
    $sql = "SELECT ProcedureCost FROM procedures WHERE ProcedureID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ProcedureID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $ProcedureCost = $row['ProcedureCost'];

    // Update data in invoices table
    $sql = "UPDATE invoices SET AppointmentID = ?, ProcedureID = ?, InvoiceDate = ?, TotalCost = ?, Status = ? WHERE InvoiceID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "iisdii", $AppointmentID, $ProcedureID, $InvoiceDate, $ProcedureCost, $Status, $InvoiceID);
    
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Redirect to invoices.php with a query parameter indicating success
        header('Location: invoices.php?update_success=true');
        exit();
    } else {
        echo "Error updating invoice: " . mysqli_error($con);
    }
}


?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        .customtext-bold {
            font-weight: bold;
        }

        .margin-custom {
            max-width: 1000px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="appointments.php">Appointments</a></li>
            <li class="breadcrumb-item"><a href="invoices.php">Invoices</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Invoice</li>
        </ol>
    </nav>

    <!-- Main Content -->

    <div class="container-sm my-5 margin-custom">
        <h1>Edit Invoice</h1>
        <!-- Choose Appointment dropdown here -->
        <form method="post">
            <!-- InvoiceID -->
            <input type="hidden" name="InvoiceID" value="<?php echo $InvoiceID; ?>">

            <!-- Choose Appointment dropdown -->
            <div class="customtext-bold"></br></br>Choose Appointment: </div>
            <select class="form-select my-2" name="AppointmentID" aria-label="Default select example" style="width: 500px;">
                <option selected>Open this select menu</option>
                <?php
                // Replace this query with your actual query to fetch appointments with animal names
                $sql = "SELECT a.*, o.cname AS owner_name, an.AnimalName AS animal_name 
        FROM appointments a
        INNER JOIN owners o ON a.OwnerID = o.OwnerID 
        INNER JOIN animals an ON a.AnimalID = an.AnimalID";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $optionText = $row['Date'] . " | Pet Name: " . $row['animal_name'] . " | Reason: " . $row['Reason'];
                    $selected = $AppointmentID == $row['AppointmentID'] ? 'selected' : '';
                    echo '<option value="' . $row['AppointmentID'] . '" ' . $selected . '>' . $optionText . '</option>';
                }
                ?>
            </select>

            <!-- Choose Procedure dropdown -->
            <div class="customtext-bold">Choose Procedure: </div>
            <select class="form-select my-2" name="ProcedureID" aria-label="Default select example" style="width: 500px;">
                <option selected>Open this select menu</option>
                <?php
                // Replace this query with your actual query to fetch procedures
                $sql = "SELECT * FROM procedures";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $optionText = $row['ProcedureName'] . " - ₱" . $row['ProcedureCost'];
                    $selected = $ProcedureID == $row['ProcedureID'] ? 'selected' : '';
                    echo '<option value="' . $row['ProcedureID'] . '" ' . $selected . '>' . $optionText . '</option>';
                }
                ?>
            </select>

            <div class="form-group">
                <label for="dateInput">Invoice Date:</label>
                <input type="date" class="form-control my-2" id="dateInput" name="InvoiceDate" value="<?php echo $InvoiceDate; ?>" required style="max-width: 400px;">
            </div>
            <div class="customtext-bold my-5">
                <button type="submit" name="update_invoice" class="btn btn-success my-2" style="width: 160px;">Update</button> </br>
                <a href="invoices.php" class="btn btn-dark my-2" style="width: 160px;">Go Back</a>
            </div>
        </form>

    </div>


</body>

</html>
