<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <title>Lost Packages</title>
</head>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1>Lost Packages</h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
				<nav id="sidebar-wrapper" class="col-lg-1"> <!-- 1 unit wide column -->
					<ul class="sidebar-nav">
						<li><a href="/Management/deliveries.php">Deliveries</a></li>
						<li><a href="/Management/lostpackages.php">Lost Packages</a></li>
						<li><a href="/Management/complaints/dashboard.php">Complaints</a></li>
						<li>
							<ul>
								<li><a href="/Management/complaints/dashboard.php">Dashboard</a></li>
								<li><a href="/Management/complaints/opencomplaints.php">Open Complaints</a></li>
								<li><a href="/Management/complaints/closedcomplaints.php">Closed Complaints</a></li>
								<li><a href="/Management/complaints/registercomplaint.php">Register Complaint</a></li>
							</ul>
						</li>
					</ul>
				</nav>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
					<div class="container-fluid">
                        <div id="lostpackages">
                            <table id="lostpackagestable" class="table table-hover">
                                <tr>
                                    <th>Package ID</th>
                                    <th>Related Complaint ID</th>
                                    <th>Order ID</th>
                                    <th>Addressee</th>
                                    <th>Last Checkpoint</th>
                                    <th>Date</th>
                                    <th>Days Lost</th>
                                </tr>
                                <tr>
                                    <td>1234</td>
                                    <td>54738954379</td>
                                    <td>739443</td>
                                    <td>Jan Banaan inc.</td>
                                    <td>Belgium</td>
                                    <td>25/02/2021</td>
                                    <td>12</td>
                                </tr>
                            </table>
                        </div>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>
</html>