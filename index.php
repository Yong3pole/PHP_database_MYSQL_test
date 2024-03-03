<?php
include 'connect.php'; //connect to database, error when fails

if (isset($_POST['submit'])) {
    $cname = $_POST['cname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Check if any of the required fields are empty
    if (empty($cname) || empty($phone) || empty($address)) {
        // Display an error message if any of the required fields are empty
        $error_message = "Please fill in all required fields.";
    } else {
        //insert query
        $sql = "INSERT INTO owners (cname, phone, address) 
            VALUES ('$cname', '$phone', '$address')";

        $result = mysqli_query($con, $sql);
        if (!$result) {
            die(mysqli_error($con));
        } else {
            $success_message = "Records Added";
        }
    }
}

if (isset($_POST['view_all'])) {
    header('location:read.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clinic Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Clinic Records</li>
        </ol>
    </nav>

    <div class="container my-5">
        <?php
        if (isset($error_message)) {
            echo '<div class="alert alert-danger">' . $error_message . '</div>';
        } else if (isset($success_message)) {
            echo '<div class="alert alert-success">' . $success_message . '</div>';
        }
        ?>
        <form method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="Enter Name" name="cname" autocomplete="off" style="width: 400px">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput3" class="form-label">Phone</label>
                <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Phone" name="phone" autocomplete="off" style="width: 400px">
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput4" class="form-label">Address</label>
                <input type="text" class="form-control" id="exampleFormControlInput4" placeholder="Enter Address" name="address" autocomplete="off" style="width: 400px">
            </div>
            <button class="btn btn-primary btn-lg my-5" name="submit">Create Record</button>
            </br><button class="btn btn-success btn-lg" name="view_all">View All Records</button><br>
            <a href="dashboard.php" class="btn btn-dark btn-lg my-2">Exit to Dashboard</a>
        </form>
    </div>
</body>

</html>
