<?php
    $con = mysqli_connect('localhost','root','','clinic');
    if(!$con){
        die(mysqli_error("Error"+$con));
    }
?>
