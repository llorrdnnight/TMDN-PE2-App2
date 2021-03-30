<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/HR/css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/HR/css/test.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script><!-- J+query -->
    <script src="/HR/js/addRows.js"></script>
    <script src="/HR/js/verloftest.js"></script>
    <title>Document</title>
</head>
<body>
    <header><a href="#">Dit is de header</a></header>

    <div>
        <h1>Nieuwe verlof periode of afwezigheid inplannen</h1>

        <div class="container-fluid">
            <?php require($_SERVER["DOCUMENT_ROOT"] . "/HR/components/leavenav.php"); ?>

            <form name="nlform" action="NIEUWVERLOF.php" method="POST" class="needs-validation pt-3">
                <div class="form-row">
                    <div class="col-lg-2">
                        <select id="branch" class="form-control">
                            <option selected disabled>Select Office or Branch</option>
                            <option>test</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <input id="employee" name="abc" class="form-control" placeholder="Employee" disabled>
                        <div>
                            <p id="employeelist"></p>
                        </div>
                    </div>

                    <div class="col-lg-6"></div>

                    <div class="col-lg-2">
                        <input type="button" class="btn btn-success form-control" value="submit">
                    </div>
                </div>

                <div class="form-row pt-3">
                    <div class="col-lg-2">
                        <input id="Periods" name="Periods" type="text" class="form-control" value="1" disabled>
                    </div>

                    <div class="col-lg-1">
                        <input id="button-addcolumn" class="form-control btn btn-success" type="button" value="Add">
                    </div>

                    <div class="col-lg-1">
                        <input id="button-removecolumn" class="form-control btn btn-danger" type="button" value="Remove">
                    </div>

                    <div class="col-lg-6"></div>

                    <div class="col-lg-2">
                        <input type="button" class="btn btn-secondary form-control" value="reset">
                    </div>
                </div>

                <div class="form-row pt-5">
                    <table id="table-leave" class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nummer</th>
                                <th>Soort</th>
                                <th>Start Periode</th>
                                <th>Eind Periode</th>
                                <th>Aantal Dagen</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody id="table-leave-tbody">
                            <tr>
                                <td>1</td>
                                <td>
                                    <select>
                                        <option selected>Verlof</option>
                                        <option>Ziekte</option>
                                        <option>Andere?</option>
                                    </select>
                                </td>
                                <td><input type="date"></td>
                                <td><input type="date"></td>
                                <td><input type="text" disabled placeholder="0"></td>
                                <td><input type="text"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</body>
</html>