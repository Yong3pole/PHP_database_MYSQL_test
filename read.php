<?php
    include 'connect.php';

    // Check if ID is set and is valid
    if (isset($_GET['deleteid'])) {
        $ID = filter_var($_GET['deleteid'], FILTER_SANITIZE_NUMBER_INT);

        // Delete the owner with the given ID
        $stmt = mysqli_prepare($con, "DELETE FROM owners WHERE ID = ?");
        mysqli_stmt_bind_param($stmt, "i", $ID);
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
    
    <div class="container my-5">
        <h2>Students</h2>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Email</th>
                    <th scope="col">Mobile</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // select query or READ query
                $sql = "SELECT * FROM owners";
                $result = mysqli_query($con, $sql);

                while ($row = mysqli_fetch_assoc($result)) {

                    $ID = $row['ID'];
                    $fname = $row['fname'];
                    $lname = $row['lname'];
                    $email = $row['email'];
                    $mobile = $row['mobile'];
                    echo '<tr>
                    <th scope="row">' . $ID . '</th>
                    <td>' . $fname . '</td>
                    <td>' . $lname . '</td>
                    <td>' . $email . '</td>
                    <td>' . $mobile . '</td>
                    <td>
                    <a href="update.php?updateid='.$ID.'" class="btn btn-primary btn-sm">Update</a>
                    <a href="read.php?deleteid='.$ID.'" class="btn btn-danger btn-sm">Delete</a>
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
