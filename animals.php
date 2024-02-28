<?php
include 'connect.php';
$ownerid = filter_var($_GET['ownerid'], FILTER_SANITIZE_NUMBER_INT);

$stmt = mysqli_prepare($con, "SELECT cname FROM owners WHERE OwnerID = ?");
mysqli_stmt_bind_param($stmt, "i", $ownerid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $cname = $row['cname'];
} else {
    $cname = "Unknown";
}

if (isset($_POST['submit'])) {
    // Get the form data
    $AnimalName = $_POST['AnimalName'];
    $Type = $_POST['Type'];
    $Age = $_POST['Age'];

    // Generate a random integer for AnimalID
    $AnimalID = mt_rand(10000, 99999);

    // Insert the data into the animals table
    $stmt = mysqli_prepare($con, "INSERT INTO animals (AnimalID, AnimalName, Type, Age, OwnerID) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isssi", $AnimalID, $AnimalName, $Type, $Age, $ownerid);
    mysqli_stmt_execute($stmt);

    // Check if the data was successfully inserted
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        $success_message = "Pet record added successfully!";
    } else {
        $error_message = "Error adding pet record: " . mysqli_error($con);
    }
}

// Retrieve pet records for the owner
$stmt = mysqli_prepare($con, "SELECT AnimalID, AnimalName, Type, Age FROM animals WHERE OwnerID = ?");
mysqli_stmt_bind_param($stmt, "i", $ownerid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Custom CSS for the form */
        .input-box {
            border: 1px solid #ced4da;
            /* Changed border width to 1px */
            border-radius: 5px;
            padding: 50px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <h2>Pet Records of <?php echo $cname; ?> - OwnerID#<?php echo $ownerid ?></h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">AnimalID#</th>
                    <th scope="col">PetName</th>
                    <th scope="col">Type</th>
                    <th scope="col">Age (months)</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through each pet record and display it in the table
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['AnimalID'] . '</td>';
                    echo '<td>' . $row['AnimalName'] . '</td>';
                    echo '<td>' . $row['Type'] . '</td>';
                    echo '<td>' . $row['Age'] . '</td>';
                    echo '<td>
                            <a href="update.php?updateid=' . $row['AnimalID'] . '" class="btn btn-primary btn-sm">Update</a>
                            <a href="read.php?deleteid=' . $row['AnimalID'] . '" class="btn btn-danger btn-sm">Delete</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="container my-5">
        <div class="input-box">
            <form method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput2" class="form-label">Pet Name</label>
                    <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="Enter Pet Name" name="AnimalName" autocomplete="off" style="width: 400px">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput3" class="form-label">Type</label>
                    <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Type eg. Dog" name="Type" autocomplete="off" style="width: 400px">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput4" class="form-label">Age</label>
                    <input type="text" class="form-control" id="exampleFormControlInput4" placeholder="Enter Age in months" name="Age" autocomplete="off" style="width: 400px">
                </div>
                <button class="btn btn-primary btn-lg my-3" name="submit">Add Pet Record</button>
            </form>
            <a href="read.php" class="btn btn-dark btn-lg">Go Back</a>
        </div>
    </div>
</body>

</html>
