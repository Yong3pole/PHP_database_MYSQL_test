<?php
// Check if the URL parameter 'login_success' is present and display an alert
if (isset($_GET['login_success']) && $_GET['login_success'] == 'true') {
  echo '<script>alert("Login successful!")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
            background-image: url('https://banner2.cleanpng.com/20180531/kyh/kisspng-dogcat-relationship-dogcat-relationship-pet-5b109c9934bc24.752549791527815321216.jpg');
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
  </style>
</head>

<body>
  <div class="container my-5">
    <h1 class="text-center mb-5">PetCare Animal Clinic</h1>
    <div class="row justify-content-center">
      <div class="col-3">
        <div class="d-grid gap-4">
          <a href="index.php" class="btn btn-primary btn-lg">Clinic Records</a>
          <a href="appointments.php" class="btn btn-primary btn-lg">Appointments</a>
        </div>
      </div>
    </div>
    <div class="row justify-content-center my-5">
      <div class="col-3 my-5">
        <div class="d-grid gap-4 my-5">
          <a href="login.php" class="btn btn-danger btn-lg">Logout</a>
        </div>
      </div>
    </div>
  </div>


</body>

</html>