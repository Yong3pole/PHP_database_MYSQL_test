<?php
    $con = mysqli_connect('localhost','root','','DataBabies');
    if(!$con){
        die(mysqli_error("Error"+$con));
    }
?>