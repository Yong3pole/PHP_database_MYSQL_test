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
                    <th style="width: 200px;">AppointmentID</th>
                    <th style="width: 200px;">ProcedureID</th>
                    <th style="width: 250px;">InvoiceDate</th>
                    <th style="width: 150px;">TotalCost</th>
                    <th style="width: 200px;">Status</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="margin-custom customtext-bold my-5">________________________</br>
        <a href="addInvoices.php" class="btn btn-success margin-custom my-2" style="width: 160px;">Create Invoice</a> </br>
        <a href="appointments.php" class="btn btn-dark margin-custom" style="width: 160px;">Go Back</a>
    </div>

</body>

</html>
