<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/HR/components/head.php"); ?>
    <script src="/TMDN-PE2-App2/HR/js/addRows.js"></script>
    <script src="/TMDN-PE2-App2/HR/js/verloftest.js"></script>
    <title>New leave</title>
</head>
<body>
    <div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header><a href="newleave.php">Leave</a></header>
                        </div>
                    </div>

                    <div class="row flex-grow-1">
                        <div class="col-lg-12 g-0 pt-2">
                            <?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/HR/components/leavenav.php"); ?>

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
                </div>
            </div>
        </div>
    </div>
</body>
</html>