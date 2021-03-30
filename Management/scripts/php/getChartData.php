<?php
    function getDaysOpen($Complaint)
    {
        $CurrentDate = new Datetime("now");
        $ComplaintDate = new DateTime($Complaint["Date"]);
        $Datediff = $ComplaintDate->diff($CurrentDate)->format("%a");

        return $Datediff;
    }

    function fillMonthList($startdate, $enddate)
    {
        $list = array();

        while ($startdate <= $enddate)
        {
            $list[$startdate->format("Y-m")] = 0;
            $startdate->add(new DateInterval("P1M"));
        }

        return $list;
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

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if (isset($_GET["Category"]))
        {
            $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/Management/database.json"), true);
            $Days = array(0, 7, 30, 90, 180, 365);
            $Data = array(0, 0, 0, 0, 0, 0);
            
            $Status = "";
            if (in_array($_GET["Category"], ["Open", "Closed", "On Hold"]))
            $Status = $_GET["Category"];
            
            foreach($json["Complaints"] as $Complaint)
            {
                if ($Complaint["Status"] == $Status)
                {
                    for ($i = count($Days) - 1; $i > -1; $i--)
                    {
                        $Daysopen = getDaysOpen($Complaint);
                        
                        if ($Daysopen > $Days[$i])
                        {
                            $Data[$i] += 1;
                            break;
                        }
                    }
                }
            }
            
            echo json_encode($Data);
        }
        elseif (isset($_GET["StartDate"]) && isset($_GET["EndDate"]))
        {
            //Get database
            $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/Management/database.json"), true);

            //Get variables
            $StartDate = new DateTime($_GET["StartDate"]);
            $EndDate = new DateTime($_GET["EndDate"]);

            //Dictionary of open and closed months with their amount of complaints
            $OpenMonthList = fillMonthList(clone $StartDate, clone $EndDate);
            $ClosedMonthList = fillMonthList(clone $StartDate, clone $EndDate);
            
            //Loop over every complaint. If it falls within the asked dates => check its status => push to correct month list
            foreach ($json["Complaints"] as $Complaint)
            {
                $ComplaintDate = new DateTime($Complaint["Date"]);
                if ($ComplaintDate > $StartDate && $ComplaintDate < $EndDate)
                {
                    if ($Complaint["Status"] == "Open")
                        $OpenMonthList[$ComplaintDate->format("Y-m")] += 1;
                    else
                        $ClosedMonthList[$ComplaintDate->format("Y-m")] += 1;
                }
            }

            //Clean month list of 0 values, they are not needed (TODO: only remove leading 0 values like in python strip() function)
            $OpenMonthList = cleanMonthList($OpenMonthList);
            $ClosedMonthList = cleanMonthList($ClosedMonthList);

            //Get month list with the most non zero values => create alphabetical list from numerical month values
            if (count($OpenMonthList) > count($ClosedMonthList))
                $Label = createLabel($OpenMonthList);
            else
                $Label = createLabel($ClosedMonthList);

            echo json_encode(array("Labels" => $Label, "OpenMonths" => array_values($OpenMonthList), "ClosedMonths" => array_values($ClosedMonthList)));
        }
    }
?>
