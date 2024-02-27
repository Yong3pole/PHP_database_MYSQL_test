<?php
    include 'connect.php';

    // If updateid is not set, redirect to index.php
    if (!isset($_GET['updateid'])) {
        header('Location: index.php');
        exit;
    }

    // Sanitize the input
    $ID = filter_var($_GET['updateid'], FILTER_SANITIZE_NUMBER_INT);

    // Select the owner with the given ID
    $stmt = mysqli_prepare($con, "SELECT * FROM owners WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $ID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the owner details
    if ($row = mysqli_fetch_assoc($result)) {
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
        $mobile = $row['mobile'];
    } else {
        echo "Owner not found.";
        exit;
    }

    // Handle form submission
    if (isset($_POST['update'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];

        // Update the owner with the new details
        $stmt = mysqli_prepare($con, "UPDATE owners SET fname=?, lname=?, email=?, mobile=? WHERE ID=?");
        mysqli_stmt_bind_param($stmt, "ssssi", $fname, $lname, $email, $mobile, $ID);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record: " . mysqli_error($con);
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    
    <div class="container my-5">
        <h1>Update Owner</h1>
        <form method="post">
            <div class="form-group mb-3 my-5">
                <label for="exampleInputEmail1" class="form-label">First Name</label>
                <input type="text" class="form-control" style="width: 400px" autocomplete="off" name="fname" value="<?php echo htmlspecialchars($fname); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputEmail1" class="form-label">Last Name</label>
                <input type="text" class="form-control" style="width: 400px" autocomplete="off" name="lname" value="<?php echo htmlspecialchars($lname); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputEmail1" class="form-label">Email</label>
                <input type="text" class="form-control" style="width: 400px" autocomplete="off" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputEmail1" class="form-label">Mobile</label>
                <input type="text" class="form-control" style="width: 400px" autocomplete="off" name="mobile" value="<?php echo htmlspecialchars($mobile); ?>">
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update</button>
            <a href="read.php" class="btn btn-secondary">Go Back</a>

        </form>
    </div>
</body>

</html>
