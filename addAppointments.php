<?php
include 'connect.php';

if (isset($_POST['update'])) {
    // Retrieve the form data
    $OwnerID = $_POST['OwnerID'];
    $AnimalID = $_POST['AnimalID'];
    $Date = $_POST['Date'];
    $Reason = $_POST['Reason'];


    // Generate a random AppointmentID (in this example, we're using a simple random number between 10000 and 99999)
    $AppointmentID = rand(10000, 99999);

    // Insert the appointment into the appointments table
    $stmt = mysqli_prepare($con, "INSERT INTO appointments (OwnerID, AnimalID, AppointmentID, Date, Reason) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iisss", $OwnerID, $AnimalID, $AppointmentID, $Date, $Reason);

    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $success_message = "Appointment Created";
        echo '<div class="alert alert-success">' . $success_message . '</div>';
        header('Location: appointments.php?add_success=true');
        exit;
    } else {
        echo "Error creating appointment: " . mysqli_error($con);
    }
}


$OwnerID = $_GET['OwnerID'];
$result = mysqli_query($con, "SELECT * FROM owners WHERE OwnerID = $OwnerID");
$pets = mysqli_query($con, "SELECT * FROM animals WHERE OwnerID = $OwnerID");
$row = mysqli_fetch_assoc($result);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Appointment</title>
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

        .margin-dropdown {
            max-width: 300px;
        }
    </style>

</head>

<body>
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="appointments.php">Appointments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Appointment</li>
        </ol>
    </nav>
    <div class="container">
        <h1 class="text-center my-3">Add Appointment for <?php echo $row['cname']; ?></h1>
        <div class="margin-custom my-5">
            <form method="POST">
                <input type="hidden" name="OwnerID" value="<?php echo $OwnerID; ?>">
                <div class="form-group">
                    <label for="petSelect">Select Pet:</label>
                    <select class="form-select my-2" id="petSelect" name="AnimalID" style="max-width: 400px;">
                        <option value="">Select Pet</option>
                        <?php while ($rowpets = mysqli_fetch_assoc($pets)) { ?>
                            <option value="<?php echo $rowpets['AnimalID']; ?>"><?php echo $rowpets['AnimalName']; ?> (<?php echo $rowpets['Type']; ?>)</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dateInput">Date of Appointment:</label>
                    <input type="date" class="form-control my-2" id="dateInput" name="Date" required style="max-width: 400px;">
                </div>
                <div class="form-group">
                    <label for="reasonInput">Reason for Appointment:</label>
                    <input type="text" class="form-control my-2" id="reasonInput" name="Reason" required style="max-width: 400px;">
                </div>
                <button type="submit" name="update" class="btn btn-primary my-5">Create Appointment</button>
                <div>
                    <a href="appointments.php" class="btn btn-dark">Go Back</a>
                </div>
            </form>
        </div>
    </div>
    </div>
</body>

</html>
