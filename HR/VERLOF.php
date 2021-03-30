<?php
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/HR/TEMPDB.json"), true);

    function echoRecentLeaveRequests($employees, $timeoff)
    {
        $r = 0;
        foreach ($timeoff as $period)
        {
            $fullname = $employees[$period["EmployeeID"] - 1]["Firstname"] . " " . $employees[$period["EmployeeID"] - 1]["Surname"];
            $datestart = new DateTime($period["Daterange"][0]);
            $dateend = new DateTime($period["Daterange"][1]);
            $row = "";
            $row .= "<tr>";
            $row .= "<td>" . $fullname . "</td>";
            $row .= "<td>" . $datestart->diff($dateend)->format("%a") . "</td>";
            $row .= "<td>" . $period["RequestDate"] . "</td>";
            $row .= "<td>" . $datestart->format("Y-m-d") . " | " . $dateend->format("Y-m-d") . "</td>";
            $row .= "</tr>";
            
            echo $row;

            // TODO: remove this, replace with non approved leave requests
            $r++;
            if ($r > 4)
                break;
        }
    }

    function echoMonthlyLeaveReport($employees, $timeoff)
    {
        //Create DateTime object of today
        $today = new DateTime("Now");

        //Set up table and 2 table headers
        $table = $theadrow1 = $theadrow2 = $tbody = "";
        $table .= "<table class='table table-hover table-sm col-lg-12 text-center'><colgroup><col span='1' class='text-left'</colgroup>";
        $theadrow1 .= "<thead><tr class='table-head'><th>Maand</th><th></th>";
        $theadrow2 = "<thead><tr><th>Werknemer</th><th>Periode</th>";
        $tbody = "<tbody>";
        //Add data to table headers
        for ($i = 0; $i < 31; $i++)
        {
            $theadrow1 .= "<th>" . $today->format("D") . "</th>";
            $theadrow2 .= "<th>" . $today->format("d") . "</th>";

            $today->add(new DateInterval("P1D"));
        }

        $theadrow1 .= "</tr></thead>";
        $theadrow2 .= "</tr></thead>";
        $table .= $theadrow1;
        $table .= $theadrow2;

        //placeholder datetime aangezien het hierboven ge increment is
        $today = new DateTime("now");
        $nextmonth = new DateTime("now");
        $nextmonth->add(new DateInterval("P1M"));

        //dit zou dus in de bovenstaande for loop gestoken moeten worden
        foreach($timeoff as $period)
        {
            $dateiterator = new DateTime("now");
            $startdate = new DateTime($period["Daterange"][0]);
            $enddate = new DateTime($period["Daterange"][1]);

            $row = "<tr><td>" . $employees[$period["EmployeeID"] - 1]["Firstname"] . "</td>";
            $row .= "<td>" . $startdate->diff($enddate)->format("%a") . "</td>";

            //If the Daterange starts before the end of the interval and ends after today
            if ($startdate <= $nextmonth && $enddate >= $today) //fill row with active and non active days
            {
                for ($i = 0; $i < 31; $i++)
                {
                    if ($dateiterator >= $startdate && $dateiterator <= $enddate)
                        $row .= "<td class='bg-red'></td>";
                    else
                        $row .= "<td class='bg-green'></td>";

                    $dateiterator->add(new DateInterval("P1D"));
                }
            }
            else //fill row with active days
            {
                for ($i = 0; $i < 31; $i++)
                {
                    $row .= "<td class='bg-green'></td>";
                }
            }

            //add rows to table
            $tbody .= $row;
        }

        $tbody .= "</tbody>";
        $table .= $tbody;
        $table .= "</table>";

        echo $table;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/HR/css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/HR/css/test.css">
    <title>Document</title>
</head>
<body>
    <header>
        Dit is de header
    </header>

    <div>
        <h1>Lijst van verlofperiodes (placeholder)</h1>

        <div class="container-fluid no-gutters">
            <?php require($_SERVER["DOCUMENT_ROOT"] . "/HR/components/leavenav.php"); ?>


            <!-- <div id="filter">
                <div>
                    <input id="calendar" type="date" name="calendar">
                </div>

                <div>
                    <br/><br/><br/>
                    <ul>
                        <li class="title">Aanvraag</li>
                        <li><input type="checkbox" name="Verlof" value="Verlof"><label for="Verlof">Verlof</label></li>
                        <li><input type="checkbox" name="Onbeschikbaar" value="Onbeschikbaar"><label for="Onbeschikbaar">Onbeschikbaar</label></li>
                    </ul>
                    <br/><br/><br/>
                    <ul>
                        <li class="title">Status</li>
                        <li><input type="checkbox" name="Nieuw" value="Nieuw"><label for="Nieuw">Nieuw</label></li>
                        <li><input type="checkbox" name="Goedgekeurd" value="Goedgekeurd"><label for="Goedgekeurd">Goedgekeurd</label></li>
                        <li><input type="checkbox" name="Niet Goedgekeurd" value="Niet Goedgekeurd"><label for="Niet Goedgekeurd">Niet Goedgekeurd</label></li>
                    </ul>
                </div>
            </div> -->

            <div class="row">
                <div class="recentdiv col-lg-6">
                    <table id="recent" class="table table-hover table-sm">
                        <thead>
                            <tr class="table-head">
                                <th colspan="4">Verlof aanvragen</th>
                            </tr>
                        </thead>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Days</th>
                                <th>Request Date</th>
                                <th>Period</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echoRecentLeaveRequests($json["Employees"], $json["TimeOff"]); ?>
                        </tbody>
                    </table>
                </div>
            
                <div class="unavailable col-lg-6">
                </div>
            </div>
            
            <div class="calendar col-lg-12">
                <?php echoMonthlyLeaveReport($json["Employees"], $json["TimeOff"]); ?>
            </div>

        </div>
    </div>
</body>
</html>