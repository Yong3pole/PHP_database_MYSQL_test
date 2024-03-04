<?php
include 'connect.php';

// Initialize the error and success messages
$error_message = $success_message = "";

// Check if the form was submitted
if (isset($_POST['submit'])) {

    // Retrieve form data
    $cname = $_POST['cname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Check if any of the required fields are empty
    if (empty($cname) || empty($phone) || empty($address)) {
        $error_message = "Please fill in all required fields.";
    } else {
        // Insert data into database
        $sql = "INSERT INTO owners (cname, phone, address) VALUES ('$cname', '$phone', '$address')";
        $result = mysqli_query($con, $sql);

        // Check if the query was successful
        if ($result) {
            $success_message = "Records Added";
        } else {
            $error_message = "Error: " . mysqli_error($con);
        }
    }
}

// Close the database connection
mysqli_close($con);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customers Area</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="https://youtu.be/PVgH0K9J6eg?t=145" target="_blank">Watch Dr. KasingKasing</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="schedAppointment.php" onclick="return confirmPersonalForm()">Schedule Appointment</a></li>
                            <li><a class="dropdown-item" href="addPet.php" onclick="return confirmPersonalForm()">Add Pet Record (to existing Owners)</a></li>

                            <script>
                                function confirmPersonalForm() {
                                    // Ask the user if they have created a personal form
                                    var confirmation = confirm("Have you created a personal form? If yes, press 'OK'");

                                    // If the user confirms, navigate to schedAppointment.php
                                    if (confirmation) {
                                        window.location.href = "schedAppointment.php";
                                        return true;
                                    } else {
                                        // If the user cancels, stay on the current page
                                        return false;
                                    }
                                }
                            </script>
                        </ul>
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
        <h1 class="text-center my-5">Customers Area</h1>

        <label class="text my-5 mb-4 text-center"><strong><span style="font-size: 20px;"> Personal Form</label></strong>
        <form method="post">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="cname" placeholder="text">
                        <label for="fullName">Full Name</label>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center ">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="phone" placeholder="text">
                        <label for="contact">Contact</label>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-floating mb-5">
                        <input type="text" class="form-control" name="address" placeholder="text">
                        <label for="address">Address</label>
                    </div>
                </div>
            </div>
            <button name="submit" class="btn btn-primary btn-lg mb-5">Submit</button>
        </form>

    </div>
</body>

</html>