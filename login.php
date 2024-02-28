<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the username and password match the hardcoded values
    if ($_POST['username'] == 'admin' && $_POST['password'] == '123456789') {
        // Redirect to index.php
        header('Location: index.php');
        exit;
    } else {
        // Incorrect username or password
        echo '<div class="alert alert-danger" role="alert">Incorrect username or password</div>';
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://png2.cleanpng.com/sh/db1fdbaf3e93f8704452bf78946bebf7/L0KzQYm3VcMyN5pngJH0aYP2gLBuTfRwb5RmjJ97ZXzkhLr2jwNpcaEyfNHwY3H3PcPsjPF1cZDzi9pycD3zdcW0VfIyOGpoUasAYkjkRYm1V8QzOmY2Tak6NUK6SIK8U8IyO2g6RuJ3Zx==/kisspng-dogcat-relationship-dogcat-relationship-pet-5b109c995b8a58.742251571527815321375.png');
            background-size: cover;
            background-position: center;
            height: 100vh; /* Ensures the background image covers the entire viewport */
        }
        .container {
            max-width: 800px;
            margin: 20px auto 0; /* Add a top margin of 20px */
            padding: 20px; /* Add some padding for better spacing */
            background-color: rgba(135, 206, 250, 0.8); /* Sky blue background color */
            border: 2px solid white; /* White border */
            border-radius: 10px; /* Add some rounded corners */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a subtle shadow effect */
        }
        .my-custom-margin {
            margin-bottom: 5rem;
            margin-top: 5rem; /* Add a top margin to the form */
        }
        .custom-label {
            width: 100px; /* Adjust this width as needed */
            padding-top: 7px; /* Add padding to vertically align the label with the input */
            font-weight: bold;
        }
        .custom-input {
            width: calc(100% - 100px); /* Subtract the label width from 100% to calculate the input width */
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1 class="col-sm-15 text-center my-5">  Login Page  </h1>
        <form class="d-flex justify-content-center my-custom-margin" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        
            <div class="col-sm-8">
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <label for="inputEmail3" class="col-form-label custom-label">Username</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" class="form-control custom-input" id="inputEmail3" name="username">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-2">
                        <label for="inputPassword3" class="col-form-label custom-label">Password</label>
                    </div>
                    <div class="col-sm-10">
                        <input type="password" class="form-control custom-input" id="inputPassword3" name="password">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <button type="submit" class="btn btn-primary btn-lg">Sign in</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
