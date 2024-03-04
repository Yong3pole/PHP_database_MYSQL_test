<?php
include 'connect.php';
if (isset($_GET['update_success']) && $_GET['update_success'] == 'true') {
    echo '<div class="alert alert-success">Invoice updated successfully!</div>';
}


if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    echo '<div class="alert alert-success">Invoice deleted successfully!</div>';
}



?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoices</title>
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

        /* Hover effect */
        .hover-details {
            position: relative;
            cursor: pointer;
        }

        .hover-details .details {
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            display: none;
            z-index: 1000;
        }

        .hover-details:hover .details {
            display: block;
        }

        .appointment-link {
            color: blue;
            text-decoration: underline;
            cursor: default;
            /* Prevent the pointer cursor */
        }
    </style>
</head>

<body>
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="appointments.php">Appointments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Invoices</li>
        </ol>
    </nav>

    <div class="container">
        <h1 class="text-center my-3">INVOICES</h1>
        <table class="table margin-custom my-5">
            <thead>
                <tr>
                    <th style="width: 150px;">InvoiceID</th>
                    <th style="width: 150px;">AppointmentID</th>
                    <th style="width: 150px;">ProcedureID</th>
                    <th style="width: 150px;">InvoiceDate</th>
                    <th style="width: 100px;">TotalCost</th>
                    <th style="width: 100px;">Payment</th>
                    <th style="width: 200px; text-align: center;">Actions</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM invoices";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['InvoiceID'] . '</td>';
                    echo '<td class="hover-details">' . $row['AppointmentID'];
                    // Fetching appointment details
                    $appointment_sql = "SELECT * FROM appointments WHERE AppointmentID = " . $row['AppointmentID'];
                    $appointment_result = mysqli_query($con, $appointment_sql);
                    if ($appointment_row = mysqli_fetch_assoc($appointment_result)) {
                        echo '<div class="details">';
                        echo 'Pet ID: ' . $appointment_row['AnimalID'] . '<br>';
                        echo 'Appointment Date: ' . $appointment_row['Date'] . '<br>';
                        echo 'Reason: ' . $appointment_row['Reason'];
                        echo '</div>';
                    }
                    echo '</td>';
                    echo '<td class="hover-details">' . $row['ProcedureID'];
                    $procedure_sql = "SELECT * FROM procedures WHERE ProcedureID = " . $row['ProcedureID'];
                    $procedure_result = mysqli_query($con, $procedure_sql);
                    if ($procedure_row = mysqli_fetch_assoc($procedure_result)) {
                        echo '<div class="details">';
                        echo 'Procedure Name: ' . $procedure_row['ProcedureName'] . '<br><br>';
                        echo 'Procedure Cost: ' . $procedure_row['ProcedureCost'];
                        echo '</div>';
                    }
                    echo '</td>';
                    echo '<td>' . $row['InvoiceDate'] . '</td>';
                    echo '<td>' . $row['TotalCost'] . '</td>';
                    echo '<td>' . (($row['Status'] == 0) ? '✗' : '✓') . '</td>';
                    echo '<td>';
                    echo '<a href="editInvoice.php?id=' . $row['InvoiceID'] . '" class="btn btn-primary mx-2">Edit</a>'; // Edit link
                    echo '<a href="deleteInvoice.php?id=' . $row['InvoiceID'] . '" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to delete this invoice?\');">Delete</a>'; // Delete link
                    echo '</td>';
                    echo '</tr>';
                }

                ?>
            </tbody>

        </table>
    </div>
    <div class="container">
        <div class="margin-custom customtext-bold my-5">________________________</br>
            <a href="addInvoices.php" class="btn btn-success margin-custom my-2" style="width: 160px;">Create Invoice</a> </br>
            <a href="appointments.php" class="btn btn-dark margin-custom" style="width: 160px;">Go Back</a>
        </div>
    </div>

</body>

</html>