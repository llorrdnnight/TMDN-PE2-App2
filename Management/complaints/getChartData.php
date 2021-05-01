<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/PATHS.PHP");

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if (isset($_GET["Category"]))
        {

            $json = json_decode(file_get_contents(MANAGEMENTDIR . "database.json"), true);
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
            
        }
    }
        
    function getDaysOpen($Complaint)
    {
        $CurrentDate = new Datetime("now");
        $ComplaintDate = new DateTime($Complaint["Date"]);
        $Datediff = $ComplaintDate->diff($CurrentDate)->format("%a");

        return $Datediff;
    }
?>
