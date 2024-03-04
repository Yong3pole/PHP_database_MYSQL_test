<?php
include 'connect.php';

if (isset($_POST['submit'])) {
    // Get the form data
    $AnimalName = $_POST['AnimalName'];
    $Type = $_POST['Type'];
    $Age = $_POST['Age'];
    $OwnerID = $_POST['OwnerID'];

    // Validate input fields
    if (!empty($AnimalName) && !empty($Type) && !empty($Age) && !empty($OwnerID)) {
        // Generate a random integer for AnimalID
        $AnimalID = mt_rand(10000, 99999);
        // Insert the data into the animals table
        $stmt = mysqli_prepare($con, "INSERT INTO animals (AnimalID, AnimalName, Type, Age, OwnerID) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isssi", $AnimalID, $AnimalName, $Type, $Age, $OwnerID);
        mysqli_stmt_execute($stmt);

        // Check if the data was successfully inserted
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $success_message = "Pet record added successfully!";
        } else {
            $error_message = "Error adding pet record: " . mysqli_error($con);
        }
    } else {
        $error_message = "Please fill in all the fields.";
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
                </ul>
                
            </div>
        </div>
    </nav>
    <div class="container my-5 text-center" style="margin: auto;">
        <h1 class="text-center my-5 mb-5">Add Pet Record to Existing Customers</h1>
        <?php if (!empty($success_message)) : ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?></div>
        <?php endif; ?>
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
                    <div class="form-group">
                        <label for="animalNameInput">Pet Name:</label>
                        <input type="text" class="form-control my-2" id="animalNameInput" name="AnimalName" required>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="typeInput">Type:</label>
                        <input type="text" class="form-control my-2" id="typeInput" name="Type" required>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label for="ageInput">Age:</label>
                        <input type="number" class="form-control my-2" id="ageInput" name="Age" required>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary btn-lg my-3" name="submit">Add Pet Record</button>
        </form>
    </div>



</body>

</html>