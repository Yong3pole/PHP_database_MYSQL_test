<?php
include 'connect.php';

if (isset($_POST['create_invoice'])) {
    // Retrieve form data
    $AppointmentID = $_POST['AppointmentID'];
    $ProcedureID = $_POST['ProcedureID'];
    $InvoiceDate = $_POST['InvoiceDate'];

    // Get ProcedureCost from procedures table
    $sql = "SELECT ProcedureCost FROM procedures WHERE ProcedureID = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $ProcedureID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $ProcedureCost = $row['ProcedureCost'];
    $Status = isset($_POST['paid']) ? 1 : 0;
    // Generate a random InvoiceID
    $InvoiceID = rand(10000, 99999);

    // Insert data into invoices table
    $sql = "INSERT INTO invoices (InvoiceID, AppointmentID, ProcedureID, InvoiceDate, TotalCost, Status) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "iiisdi", $InvoiceID, $AppointmentID, $ProcedureID, $InvoiceDate, $ProcedureCost, $Status);

    mysqli_stmt_execute($stmt);


    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $success_message = "Invoice Created";
        echo '<div class="alert alert-success">' . $success_message . '</div>';
    } else {
        echo "Error creating invoice: " . mysqli_error($con);
    }
}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Invoice</title>
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
    <!-- Breacrumbs -->
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="appointments.php">Appointments</a></li>
            <li class="breadcrumb-item"><a href="invoices.php">Invoices</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Invoice</li>
        </ol>
    </nav>

    <!-- Main Content -->

    <div class="container-sm my-5 margin-custom">
        <h1>Create Invoice</h1>
        <!-- Choose Appointment dropdown here -->
        <form method="post">
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
                    echo '<option value="' . $row['AppointmentID'] . '">' . $optionText . '</option>';
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
                    echo '<option value="' . $row['ProcedureID'] . '">' . $optionText . '</option>';
                }
                ?>
            </select>

            <div class="form-group">
                <label for="dateInput">Invoice Date:</label>
                <input type="date" class="form-control my-2" id="dateInput" name="InvoiceDate" value="<?php echo $InvoiceDate; ?>" required style="max-width: 400px;">

                <!-- Payment made or not -->
                <div class="form-check my-4">
                    <input class="form-check-input" type="checkbox" value="" id="paid" name="paid">
                    <label class="form-check-label" for="paid">
                        Paid
                    </label>
                </div>   
            </div>

            <div class="customtext-bold my-5">
                <button type="submit" name="create_invoice" class="btn btn-success my-2" style="width: 160px;">Create</button> </br>
                <a href="invoices.php" class="btn btn-dark my-2" style="width: 160px;">Go Back</a>
            </div>
        </form>

    </div>

    <script>
        // Listen for changes in the checkbox
        document.getElementById("paid").addEventListener("change", function() {
            // Update the value of the hidden input field based on the checkbox state
            document.getElementById("status").value = this.checked ? 'true' : 'false';
        });
    </script>


</body>

</html>