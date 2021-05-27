<?php
    int a = "asd";
    exit;
    $parcels = json_decode(file_get_contents("http://10.128.30.7:8080/api/parcels"), true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Parcels</p>
    <?php 
        foreach($parcels["data"] as $parcel) 
        {
            foreach ($parcel as $key => $value)
            {
                echo $key . "<br>";
            }
            break;
        }
    ?>
</body>
</html>