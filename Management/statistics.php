<?php
    if (!isset($_SESSION)) { session_start(); };

    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");



    function echoStatistics()
    {
        $absences = json_decode(file_get_contents("http://10.128.30.7:8080/api/absences"), true);
        #$jobs = json_decode(file_get_contents("http://10.128.30.7:8080/api/jobs"), true);
        #$departements = json_decode(file_get_contents("http://10.128.30.7:8080/api/departements"), true);
        $employees = json_decode(file_get_contents("http://10.128.30.7:8080/api/employees"), true);
        $orders = json_decode(file_get_contents("http://10.128.30.7:8080/api/orders"), true)["data"];
        $parcels = json_decode(file_get_contents("http://10.128.30.7:8080/api/parcels"), true);
        $Customers = json_decode(file_get_contents("http://10.128.30.7:8080/api/customers"), true)["data"];


        $absent = array_column($absences,"employeeID");
        $count = array_count_values($absent);

        $max = 0;
        foreach ($count as $item){
            if($item > $max)
                $max = $item;
        }
        foreach ($count as $key => $item){
            if($item == $max)
            foreach($employees as $name)
                if($name["id"] == $key)
                    echo("<p> The most absent employee is " . $name["employeeFirstName"] . " " . $name["employeeLastName"] . " sitting at " . $max . " absences.</p>");
        }
        $LongestAbsenceID = 1;
        $longestY=0;
        $longestM=0;
        $longestD=0;
        foreach($absences as $item)
        {
            $date1 = new DateTime($item["startDate"]);
            $date2 = new DateTime($item["endDate"]);
            $interval = $date1->diff($date2);
            if($interval->y > $longestY)
            {
                $LongestAbsenceID = $item["employeeID"];
                $longestY = $interval->y;
                $longestM = $interval->m;
                $longestD = $interval->d;
            }
            elseif($interval->y == $longestY)
            {
                if($interval->m > $longestM)
                {
                    $LongestAbsenceID = $item["employeeID"];
                    $longestY = $interval->y;
                    $longestM = $interval->m;
                    $longestD = $interval->d;
                }
                elseif($interval->m == $longestM)
                {
                    if($interval->d > $longestD)
                    {
                        $LongestAbsenceID = $item["employeeID"];
                        $longestY = $interval->y;
                        $longestM = $interval->m;
                        $longestD = $interval->d;
                    }
                }
            }
        }
        foreach($absences as $item)
        {
            if($item["employeeID"] == $LongestAbsenceID)
            {
                $date1 = new DateTime($item["startDate"]);
                $date2 = new DateTime($item["endDate"]);
                $interval = $date1->diff($date2);
                foreach($employees as $name)
                if($name["id"] == $LongestAbsenceID)
                    echo("<p> The longest absent employee is " . $name["employeeFirstName"] . " " . $name["employeeLastName"] . " sitting at " . $interval->y . " years, " . $interval->m." months, ".$interval->d. " days .</p>");

            }
        }
        $total = 0;
        $paid = 0;
        foreach($orders as $item)
        {
            $total ++;
            if($item["isPaid"])
            $paid ++;
        }
        echo("<p> Out of  " . $total . " orders ,  " . $paid . " are paid for. </p>");

        $orderC = array_column($orders,"customerId");
        $count = array_count_values($orderC);
        $max = 0;
        $total = 0;
        $uCustomers = 0;
        foreach ($count as $item){
            if($item > $max)
                $max = $item;
        }

        foreach ($count as $key => $item){
            $uCustomers ++;
            if($item == $max)
            {
                foreach($orders as $item2)
                {
                    if($item2["customerId"] == $key)
                        $total += $item2["totalPrice"];
                }
                foreach($Customers as $name)
                if($name["id"] == $key)
                    echo("<p>Most Orders have been ordered by ".$name["firstName"] . " " . $name["lastName"] . " for a total price of ". $total ."$</p>");
            }
            echo("<p>There are a total of ". $uCustomers . " unique customers</p>");

        }

        #$job = array_column($employees,"employeeJobID");
       # $count = array_count_values($job);
       # $max = 0;
      #  $min = 99999;
        #foreach ($count as $item){
         #   if($item > $max)
        #        $max = $item;
        #    if($item < $min)
        ##        $min = $item;
        #}
        #foreach ($count as $key => $item){
         #   if($item == $max)
          #  foreach($employees as $name)
           #     if($name["id"] == $key)
            #        echo("<p> The most absent employee is " . $name["employeeFirstName"] . " " . $name["employeeLastName"] . " sitting at " . $max . " absences.</p>");
             #       if($item == $min)
            #foreach($employees as $name)
             #   if($name["id"] == $key)
              #      echo("<p> The most absent employee is " . $name["employeeFirstName"] . " " . $name["employeeLastName"] . " sitting at " . $max . " absences.</p>");
               # }



##<script src=<?= HTMLJAVASCRIPT . "getGraph.js"?#>></script>
#<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    }
?>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>

    <title>Statistics</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
<div class="container-fluid">
        <div class="h-100 d-flex flex-column justify-content-between">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <span>Stats</span>
                        </div>
                        <div class="card-body">
                            <div>
                                <?php echoStatistics() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
