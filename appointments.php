<?php
    include 'connect.php';
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
        /* Your custom CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-5">Create Appointment for Customer</h1>
        <div class="dropdown w-100">
            <button class="btn btn-secondary dropdown-toggle my-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Select Customer ID
            </button>
            <ul class="dropdown-menu">
                <?php
                $sql = "SELECT ID FROM owners";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $ID = $row['ID'];
                    echo '<li><a class="dropdown-item" href="http://localhost/create-appointments.php?ID=' . $ID . '">' . $ID . '</a></li>';
                }
                ?>
            </ul>
        </div>
        <a href="http://localhost/create-appointments.php" class="btn btn-primary">Create Appointment</a>
        <div class="container my-5">
            <p class="text-center fw-bold">CUSTOMER RECORDS</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                    </tr>
                </thead>
                <?php
                $sql = "SELECT * FROM owners";
                $result = mysqli_query($con, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    $ID = $row['ID'];
                    $cname = $row['cname'];
                    $phone = $row['phone'];
                    $address = $row['address'];
                    echo '<tr>
                            <th scope="row">' . $ID . '</th>
                            <td>' . $cname . '</td>
                            <td>' . $phone . '</td>
                            <td>' . $address . '</td>
                        </tr>';
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>
