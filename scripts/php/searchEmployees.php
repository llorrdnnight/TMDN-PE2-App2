<?php
    function findEmployeesByName($employees, $query)
    {
        $list = array();

        foreach ($employees as $employee)
        {
            $firstname = strtolower($employee["Firstname"]);
            $surname = strtolower($employee["Surname"]);
            if (strpos($firstname, $query) !== false || strpos($surname, $query) !== false)
                array_push($list, $employee);
        }

        return $list;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["query"]))
    {
        $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/HR/TEMPDB.json"), true);
        $employees = $json["Employees"];
        $query = strtolower(trim($_GET["query"]));

        echo json_encode(findEmployeesByName($employees, $query));
    }
?>