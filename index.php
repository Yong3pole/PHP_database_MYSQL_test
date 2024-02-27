<?php
    include 'connect.php'; //connect to database, error when fails

    if(isset($_POST['submit'])){
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $major=$_POST['major'];
        $GPA=$_POST['GPA'];

        // Check if any of the required fields are empty
        if(empty($fname) || empty($lname) || empty($major) || empty($GPA)){
            // Display an error message if any of the required fields are empty
            $error_message = "Please fill in all required fields.";
        } else {
            //insert query
            $sql = "INSERT INTO owners (fname, lname, major, GPA) 
            VALUES ('$fname', '$lname', '$major', '$GPA')";

            $result=mysqli_query($con,$sql);
            if(!$result){
                die(mysqli_error($con));
            }
            else{
                $success_message = "Records Added";
            }
        }
    }

    if(isset($_POST['view_all'])){
        header('location:read.php');
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container my-5">
            <?php
                if(isset($error_message)){
                    echo '<div class="alert alert-danger">'.$error_message.'</div>';
                }
                else if (isset($success_message)) {
                    echo '<div class="alert alert-success">'.$success_message.'</div>';
                }
            ?>
        <form method="post">
        <div class="mb-3">
            <label for="exampleFormControlInput2" class="form-label">First Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput2" placeholder="Enter First name" 
            name="fname" autocomplete="off" style="width: 400px">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput3" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="exampleFormControlInput3" placeholder="Enter Last name" 
            name="lname" autocomplete="off" style="width: 400px">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput4" class="form-label">major</label>
            <input type="text" class="form-control" id="exampleFormControlInput4" placeholder="Enter major" 
            name="major" autocomplete="off" style="width: 400px">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput5" class="form-label">GPA</label>
            <input type="text" class="form-control" id="exampleFormControlInput5" placeholder="Enter GPA" 
            name="GPA" autocomplete="off" style="width: 400px">
        </div>
        <button class="btn btn-primary btn-lg my-5" 
        name="submit">Submit</button>
        </br><button class="btn btn-dark btn-lg" 
        name="view_all">View All</button>
        </form>
    </div>
</body>
</html>
