<?php
// Start the session
session_start();

if (isset($_POST['generate'])) {
    
    $month = $_POST['month'];
    $day = $_POST['day'];
    $year = $_POST['year'];

    
    $_SESSION['birthdate'] = $year . "-" . $month . "-" . $day;

    header('Location: Tripole_MachineProb2.php?month='.$month.'&day='.$day.'&year='.$year.'');
    exit();
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

</head>

<body>
    <div class="container my-5 text-center">
        <h1>Enter your Birthday</h1>
        <br>
        <form method="post">
            <div class="d-flex flex-column align-items-center">
                <div class="mb-3">
                    <label class="text-center">Month</label>
                    <select class="form-select text-center" aria-label="Default select example" style="width: 150px;" name="month">
                        <option selected>Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="text-center">Day</label>
                    <select class="form-select text-center" aria-label="Default select example" style="width: 150px;" name="day">
                        <?php
                        $days = range(1, 31);
                        echo '<option selected>Select Day</option>';
                        for ($i = 0; $i < count($days); $i++) {
                            echo '<option value=' . $days[$i] . '>' . $days[$i] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="text-center">Year</label>
                    <select class="form-select text-center" aria-label="Default select example" style="width: 150px;" name="year">
                        <?php
                        $year = range(1924, 2024);
                        echo '<option selected>Select Year</option>';
                        for ($i = 0; $i < count($year); $i++) {
                            echo '<option value=' . $year[$i] . '>' . $year[$i] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="generate" class="btn btn-primary my-3">Generate Age</button>
                    <?php
                    if (isset($_SESSION['birthdate'])) {
                        $age = floor((time() - strtotime($_SESSION['birthdate'])) / 31556926);

                        if (isset($_GET['month']) && isset($_GET['day']) && isset($_GET['year'])) {
                            $month = $_GET['month'];
                            $day = $_GET['day'];
                            $year = $_GET['year'];
                        }
                    
                        $monthsarray = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
                        echo "<label class=\"text-center\"><strong><span style=\"font-size: 20px;\">Your Birthday is ".$monthsarray[$month-1]." ".$day.", ".$year.".</span></strong></label>";
                        echo "<br><label class=\"text-center\"><strong><span style=\"font-size: 20px;\">Your age is ".$age." years old.</label>";
                    }
                    ?>
            </div>
        </form>
    </div>
</body>

</html>
