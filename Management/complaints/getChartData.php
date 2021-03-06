<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["Category"]))
    {
        if ($_GET["Category"] == "Open")
            $Data = array(1, 2, 3, 4, 5, 10);
        else
            $Data = array(5, 8, 2, 1, 4, 1);

        echo json_encode($Data);
    }
?>