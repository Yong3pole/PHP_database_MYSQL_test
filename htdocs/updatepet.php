<?php
    include 'connect.php';
    $AnimalID = filter_var($_GET['updateAnimalID'], FILTER_SANITIZE_NUMBER_INT);
    $OwnerID = filter_var($_GET['ownerID'], FILTER_SANITIZE_NUMBER_INT);
    // Select the owner with the given ID

    $stmt = mysqli_prepare($con, "SELECT * FROM animals WHERE AnimalID = ?");
    mysqli_stmt_bind_param($stmt, "i", $AnimalID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $AnimalName = $row['AnimalName'];
        $Type = $row['Type'];
        $Age = $row['Age'];
    }

    if (isset($_POST['update'])) {
        $AnimalName = $_POST['AnimalName'];
        $Type = $_POST['Type'];
        $Age = $_POST['Age'];

        // Update the owner with the new details
        $stmt = mysqli_prepare($con, "UPDATE animals SET AnimalName=?, Type=?, Age=? WHERE AnimalID=?");
        mysqli_stmt_bind_param($stmt, "sssi", $AnimalName, $Type, $Age, $AnimalID);

        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $success_message = "Records Updated";
            echo '<script>alert("'.$success_message.'"); window.location.href = "animals.php?ownerid=' . $OwnerID . '";</script>';
            exit(); // Make sure to exit after the redirect
        } else {
            echo "Error updating record (Nothing was updated): " . mysqli_error($con);
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Pet Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    
    <div class="container my-5">
        <h1>Update Pet Info</h1>
        <form method="post">
            <div class="form-group mb-3 my-5">
                <label for="exampleInputaddress1" class="form-label">Animal Name</label>
                <input type="text" class="form-control" style="width: 400px" autocomplete="off" name="AnimalName" value="<?php echo htmlspecialchars($AnimalName); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputaddress1" class="form-label">Type</label>
                <input type="text" class="form-control" style="width: 400px" autocomplete="off" name="Type" value="<?php echo htmlspecialchars($Type); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputaddress1" class="form-label">Age</label>
                <input type="text" class="form-control" style="width: 400px" autocomplete="off" name="Age" value="<?php echo htmlspecialchars($Age); ?>">
            </div>
            

            <button type="submit" name="update" class="btn btn-primary my-3">Update</button>
            <br><a href="animals.php?ownerid=<?php echo $OwnerID; ?>" class="btn btn-dark">Go Back</a>


        </form>
    </div>
</body>

</html>
