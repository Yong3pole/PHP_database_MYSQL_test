<?php
include 'connect.php';
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
        <div class="customtext-bold"></br></br>Choose Appointment: </div>
        <select class="form-select my-2" aria-label="Default select example" style="width: 500px;">
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
                echo '<option value="' . $row['appointmentID'] . '">' . $optionText . '</option>';
            }
            ?>
        </select>




        <!-- Choose Procedure dropdown here -->
        <div class="customtext-bold">Choose Procedure: </div>
        <select class="form-select my-2" aria-label="Default select example" style="width: 500px;">
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

        <div class="customtext-bold my-5">Other</br>
            <a href="#" class="btn btn-success my-2" style="width: 160px;">Create</a> </br>
            <a href="invoices.php" class="btn btn-dark" style="width: 160px;">Go Back</a>
        </div>
    </div>


</body>

</html>
