<?php

include "vacatureList.php";

function printRows() {
    global $vacArr;
    
    foreach($vacArr as $vac){
        echo('<tr>');
            echo('<td>' . $vac->get_id() . '</td>');
            echo('<td>' . $vac->get_name() . '</td>');
            echo('<td>' . $vac->get_department() . '</td>');
            echo('<td>' . $vac->get_description() . '</td>');
            if($vac->get_available()){
                echo('<td>&check;</td>');
            }
            else {
                echo('<td>&#10005;</td>');
            }
        echo("</tr>");
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/vacature.css">
    <title>Vacature</title>
</head>
<body>
<div class="topnav">
    <h1>Vacature</h1>
</div>
<div id="page-content-wrapper" class="col-lg-11">
	<div class="container-fluid">
		<div class="col-lg-12 nopadding">
			<table id="orderstable" class="table table-hover table-responsive">
				<thead>
					<tr>
						<th>Id</th>
						<th>Job Title</th>
						<th>Department</th>
						<th>Description</th>
						<th>available</th>
                    </tr>
				</thead>
				<tbody>
					<?php printRows(); ?>
				</tbody>
			</table>
		</div>
	</div> <!-- End of container -->
</div>
</div>
</body>
</html>