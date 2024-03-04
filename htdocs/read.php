<?php
include 'connect.php';

// Check if OwnerID is set and is valid
if (isset($_GET['deleteid'])) {
    $OwnerID = filter_var($_GET['deleteid'], FILTER_SANITIZE_NUMBER_INT);

    // Delete the owner with the given OwnerID
    $stmt = mysqli_prepare($con, "DELETE FROM owners WHERE OwnerID = ?");
    mysqli_stmt_bind_param($stmt, "i", $OwnerID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        echo '<script>window.location.href = "read.php";</script>';
        exit;
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}

if (isset($_POST['read_return'])) {
    echo '<script>window.location.href = "index.php";</script>';
    exit; // Exit immediately after redirecting to prevent further execution
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display</title>
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
        <h2>Customer Records</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">OwnerID#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Address</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // select query or READ query
                $sql = "SELECT * FROM owners";
                $result = mysqli_query($con, $sql);

                while ($row = mysqli_fetch_assoc($result)) {

                    $OwnerID = $row['OwnerID'];
                    $cname = $row['cname'];
                    $phone = $row['phone'];
                    $address = $row['address'];
                    echo '<tr>
                    <th scope="row">' . $OwnerID . '</th>
                    <td>' . $cname . '</td>
                    <td>' . $phone . '</td>
                    <td>' . $address . '</td>
                    <td>
                    <a href="animals.php?ownerid=' . $OwnerID . '" class="btn btn-success btn-sm">Pet Records</a>
                    <a href="update.php?updateid=' . $OwnerID . '" class="btn btn-primary btn-sm">Update</a>
                    <a href="read.php?deleteid=' . $OwnerID . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this record?\');">Delete</a>
                    </td>
                </tr>';
                }
                ?>

            </tbody>
        </table>
        <form method="post">
            <button class="btn btn-dark btn-lg my-5" name="read_return">Return</button>
        </form>
    </div>

</body>

</html>