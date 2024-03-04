<?php
include 'connect.php';

// Check if form is submitted

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customers Area</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-image: url('https://www.shutterstock.com/image-photo/puppy-dog-border-collie-stethoscope-600nw-1608626725.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.5);
            /* White background color with 50% opacity */
            z-index: -1;
            /* Place the pseudo-element behind the background image */
        }

        .container {
            background-color: rgba(255, 255, 255, 0.5);
            /* White with 50% opacity */
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="">PetCare</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="customerCreate.php">Home</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Enter Customer Name" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit" style="width: 280px;">Search Appointment</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container my-5 text-center" style="margin: auto;">
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if all required fields are filled
        if ($_POST['OwnerID'] != 0 && $_POST['AnimalID'] != 'message' && isset($_POST['Date']) && isset($_POST['Reason'])) {
            $OwnerID = $_POST['OwnerID'];
            $AnimalID = $_POST['AnimalID'];
            $Date = $_POST['Date'];
            $Reason = $_POST['Reason'];
            $AppointmentID = rand(10000, 99999);
    
            // Prepare and execute the SQL statement to insert a new row into the appointments table
            $sql = "INSERT INTO appointments (OwnerID, AnimalID, AppointmentID, Date, Reason) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($con);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                die("SQL error");
            } else {
                mysqli_stmt_bind_param($stmt, "sssss", $OwnerID, $AnimalID, $AppointmentID, $Date, $Reason);
                mysqli_stmt_execute($stmt);
                $success_message = "Appointment Scheduled";
            }
        } else {
            $error_message = "Please fill in all required fields.";
        }
    }
    ?>
        <br>
        <!-- Display error message -->
        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Display success message -->
        <?php if (!empty($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <h1 class="text-center my-5">Schedule an Appointment</h1>

        <form method="post">
            <div class="row justify-content-center">
                <div class="col-md-3 mb-3">
                    <select class="form-select owner-select" aria-label="Default select example" name="OwnerID">
                        <option value="0">Select Owner</option>
                        <?php
                        $sql = "SELECT * FROM owners";
                        $result = mysqli_query($con, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . $row['OwnerID'] . '">' . $row['cname'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-3 mb-3">
                    <select class="form-select pet-select" aria-label="Disabled select example" disabled name="AnimalID">
                        <option value="0">Select Pet</option>
                    </select>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-3 text-center">
                    <div class="form-group">
                        <label for="dateInput">Date of Appointment:</label>
                        <input type="date" class="form-control my-2" id="dateInput" name="Date" required>
                    </div>
                    <div class="form-group">
                        <label for="reasonInput">Reason for Appointment:</label>
                        <input type="text" class="form-control my-2" id="reasonInput" name="Reason" required>
                    </div>
                </div>
            </div>
            <button name="submit" class="btn btn-primary btn-lg my-5">Submit</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // On change event for owner dropdown
            $('.owner-select').change(function() {
                // Get selected owner ID
                var ownerID = $(this).val();
                // If owner ID is not 0 (i.e., not "Select Owner")
                if (ownerID != 0) {
                    // Enable pet dropdown
                    $('.pet-select').prop('disabled', false);
                    // Fetch pets for selected owner
                    $.ajax({
                        type: "POST",
                        url: "fetchPets.php",
                        data: {
                            OwnerID: ownerID
                        },
                        dataType: "json",
                        success: function(response) {
                            // Clear existing options
                            $('.pet-select').find('option').remove();
                            // Append new options for pets
                            $.each(response, function(key, value) {
                                $('.pet-select').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });

                } else {
                    // If owner ID is 0, disable pet dropdown
                    $('.pet-select').prop('disabled', true);
                    // Set placeholder text
                    $('.pet-select').html('<option value="0">Select Pet</option>');
                }
            });
        });
        
    </script>

</body>

</html>