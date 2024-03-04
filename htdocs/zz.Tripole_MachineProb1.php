<?php
    $country_capital = array( "Italy"=>"Rome", "Philippines"=>"Manila", "Belgium"=>"Brussels", "Denmark"=>"Copenhagen", "Finland"=>"Helsinki", "France" => "Paris","Slovakia"=>"Bratislava", "Slovenia"=>"Ljubljana", "Germany" => "Berlin", "Greece" =>"Athens", "Ireland"=>"Dublin", "Netherlands"=>"Amsterdam", "Portugal"=>"Lisbon","Spain"=>"Madrid", "Sweden"=>"Stockholm", "United Kingdom"=>"London","Cyprus"=>"Nicosia", "Lithuania"=>"Vilnius", "Czech Republic"=>"Prague","Estonia"=>"Tallin", "Hungary"=>"Budapest", "Latvia"=>"Riga", "Malta"=>"Valetta","Austria" => "Vienna", "Poland"=>"Warsaw") ;
    asort($country_capital);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
</head>

<body>
    <?php
        foreach ($country_capital as $country => $capital) {
            echo "The capital of $country is $capital <br>" . PHP_EOL;       
        }
    ?>
</body>

</html>