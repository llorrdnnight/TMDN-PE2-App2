<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $complaints = json_decode(file_get_contents("http://10.128.30.7:8080/api/tickets"), true)["data"];

        if (isset($_GET["category"])) //Get count per daterange from each complaint category
        {
            $days = array(0, 7, 30, 90, 180, 365); //Less than 7, less than 30, less than 90, less than 180, less than 365, more than 365 days
            $data = array(0, 0, 0, 0, 0, 0);

            if ($_GET["category"] == "Open")
                $complaints = getComplaintsByAttribute($complaints, "stateId", 0);
            elseif ($_GET["category"] == "Closed")
                $complaints = getComplaintsByAttribute($complaints, "stateId", 1);
            else
                exit;
            
            foreach($complaints as $complaint)
            {
                $daysOpen = getDaysOpen($complaint);

                for ($i = count($days) - 1; $i > -1; $i--)
                {
                    if ($daysOpen > $days[$i] - 1)
                    {
                        $data[$i] += 1;
                    }
                }
            }
            
            echo json_encode($data);
        }
        elseif (isset($_GET["startDate"]) && isset($_GET["endDate"])) //Get complaints per month per category
        {
            //Get variables
            $startDate = new DateTime($_GET["startDate"]);
            $endDate = new DateTime($_GET["endDate"]);

            //Dictionary of open and closed months with their amount of complaints
            $openMonthList = $closedMonthList = fillMonthList(clone $startDate, clone $endDate);
            
            //Loop over every complaint. If it falls within the asked dates => check its status => push to correct month list
            foreach ($complaints as $complaint)
            {
                $complaintDate = new DateTime($complaint["updated_at"]);

                if ($complaintDate >= $startDate && $complaintDate <= $endDate)
                {
                    if ($complaint["stateId"] % 2 == 0)
                        $openMonthList[$complaintDate->format("Y-m")] += 1;
                    else if($complaint["stateId"] % 2 == 1)
                        $closedMonthList[$complaintDate->format("Y-m")] += 1;
                }
            }

            //Clean month list of 0 values, they are not needed (TODO: only remove leading 0 values like in python strip() function)
            $openMonthList = cleanMonthList($openMonthList);
            $closedMonthList = cleanMonthList($closedMonthList);

            //Get month list with the most month values => create alphabetical list from numerical month values
            if (count($openMonthList) >= count($closedMonthList))
                $label = createLabel($openMonthList);
            else
                $label = createLabel($closedMonthList);

            echo json_encode(array("Labels" => $label, "OpenMonths" => array_values($openMonthList), "ClosedMonths" => array_values($closedMonthList)));
        }
    }

    function getComplaintsByAttribute($complaints, $attribute, $value)
    {
        $arr = array();

        foreach ($complaints as $complaint)
        {
            if ($complaint[$attribute] % 2 == $value)
                array_push($arr, $complaint);
        }

        return $arr;
    }

    function getDaysOpen($complaint)
    {
        $currentDate = new Datetime("now");
        $complaintDate = new DateTime($complaint["updated_at"]);
        $dateDiff = $complaintDate->diff($currentDate)->format("%a");

        return $dateDiff;
    }

    function fillMonthList($startDate, $endDate)
    {
        $arr = array();

        while ($startDate <= $endDate)
        {
            $arr[$startDate->format("Y-m")] = 0;
            $startDate->add(new DateInterval("P1M"));
        }

        return $arr;
    }

    function cleanMonthList($list)
    {
        foreach ($list as $key => $value)
        {
            if ($value == 0)
                unset($list[$key]);
        }

        return $list;
    }

    function createLabel($Dates)
    {
        $Label = array();

        foreach($Dates as $key => $value)
        {
            $Date = new DateTime($key);
            array_push($Label, $Date->format('F'));
        }

        return $Label;
    }
?>