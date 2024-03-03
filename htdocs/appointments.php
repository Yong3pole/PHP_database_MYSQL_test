<?php
include 'connect.php';
if (isset($_GET['add_success'])) {
    echo '<script>alert("Appointment added!")</script>';
    echo '<script>window.location.href = "appointments.php";</script>';
    exit;
}

if (isset($_GET['delete_id'])) {
    $delete_id = filter_var($_GET['delete_id'], FILTER_SANITIZE_NUMBER_INT);
    $stmt = mysqli_prepare($con, "DELETE FROM appointments WHERE AppointmentID = ?");
    mysqli_stmt_bind_param($stmt, "i", $delete_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<script>alert("Appointment deleted!")</script>';
        echo '<script>window.location.href = "appointments.php";</script>';
        exit;
    } else {
        echo '<script>alert("Error deleting appointment!")</script>';
    }
}

$sql = "SELECT appointments.*, owners.cname AS owner_name, animals.AnimalName AS pet_name 
            FROM appointments 
            INNER JOIN owners ON appointments.OwnerID = owners.OwnerID 
            INNER JOIN animals ON appointments.AnimalID = animals.AnimalID";
$result = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
            <li class="breadcrumb-item active" aria-current="page">Appointments</li>
        </ol>
    </nav>
    <div class="container">
        <h1 class="text-center my-3">CLINIC APPOINTMENTS</h1>
        <table class="table margin-custom">
            <thead>
                <tr>
                    <th style="width: 350px;">Customer/Owner Name</th>
                    <th style="width: 250px;">Pet Name</th>
                    <th style="width: 250px;">Date</th>
                    <th style="width: 200px;">Reason</th>
                    <th style="width: 50px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['owner_name']; ?></td>
                        <td><?php echo $row['pet_name']; ?></td>
                        <td><?php echo $row['Date']; ?></td>
                        <td><?php echo $row['Reason']; ?></td>
                        <td>
                            <a href="appointments.php?delete_id=<?php echo $row['AppointmentID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="container my-5">
        <div class="margin-custom customtext-bold">Create an appointment for: </div>
        <div class="dropdown margin-custom my-2">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Select Customer
            </button>
            <ul class="dropdown-menu">
                <?php
                // select query or READ query
                $sql = "SELECT * FROM owners";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li><a class="dropdown-item" href="addAppointments.php?OwnerID=' . $row['OwnerID'] . '">' . $row['cname'] . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="margin-custom customtext-bold my-5">Other: </br>
                <a href="invoices.php" class="btn btn-success margin-custom my-2" style="width: 160px;">View Invoices</a> </br>
                <a href="dashboard.php" class="btn btn-dark margin-custom" style="width: 160px;">Go Back</a>
        </div>
    </div>
</body>

</html>
