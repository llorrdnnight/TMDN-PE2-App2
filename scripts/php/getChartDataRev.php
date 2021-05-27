<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");

    function createLabelY()
    {
        $Label = array();

        for($i = 1; $i <= 12; $i++) {
            $date = DateTime::createFromFormat('m', $i);
            array_push($Label, $date->format('F'));
        }

        return $Label;
    }

    function createLabelM($m)
    {
        $Label = array();
        $days = 0;

        if ($m == 2)
            $days = 29;
        else if (($m <= 7 && $m % 2 == 1) || ($m > 7 && $m % 2 == 0))
            $days = 31;
        else
            $days = 30;


        for($i = 1; $i <= $days; $i++) {
            array_push($Label, $i);
        }

        return $Label;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if (isset($_GET["date"]))
        {
            $json = json_decode(file_get_contents(MOCKDIR . "MOCK_DATA.json"), true);
            $orders = json_decode(file_get_contents("http://10.128.30.7:8080/api/orders"), true)["data"];
            $employeeSalary = json_decode(file_get_contents("http://10.128.30.7:8080/api/employees"), true);

            // Fill Arrays with 0's
            $yearProfits = array_fill(1, 12, 0);
            $yearExpenses = array_fill(1, 12, 0);
            $yearRevenue = array_fill(1, 12, 0);

            $monthProfits = array_fill(1, 31, 0);
            $monthExpenses = array_fill(1, 31, 0);
            $monthRevenue = array_fill(1, 31, 0);

            $totalSalary = 0;

            // Get Date
            $sp = explode("-", $_GET['date']);
            $year = $sp[0];
            $month = $sp[1];

             // Expenses
            foreach($employeeSalary as $Salary) {
                $totalSalary += $Salary["employeeSalary"];
            }
            foreach($yearExpenses as $key => $yRev){
                $yearExpenses[$key] = $totalSalary;
            }

            // We pay out our employees on the 5th
            // Because its a beautiful day
            $monthExpenses[5] = $totalSalary;

            // Profits
            foreach($orders as $Profit) {
                $split = date_parse_from_format('Y-m-d H:i:s', $Profit["created_at"]);
                if($split['year'] == $year){
                    $yearProfits[$split['month']] += $Profit['totalPrice'];

                    if($split['month'] == $month){
                        $monthProfits[$split['day']] += $Profit['totalPrice'];
                    }
                }
            }

            // Revenue
            foreach($yearRevenue as $key => $yRev){
                $yearRevenue[$key] = $yearProfits[$key] - $yearExpenses[$key];
            }

            foreach($monthRevenue as $key => $mRev){
                $monthRevenue[$key] = $monthProfits[$key] - $monthExpenses[$key];
            }
            

            $LabelY = createLabelY();
            $LabelM = createLabelM($month);

            echo json_encode(array("LabelsY" => $LabelY, "LabelsM" => $LabelM, "ExpensesY" => array_values($yearExpenses), "ProfitsY" => array_values($yearProfits), "RevenueY" => array_values($yearRevenue), "ProfitsM" => array_values($monthProfits), "ExpensesM" => array_values($monthExpenses), "RevenueM" => array_values($monthRevenue)));
        }
    }

?>