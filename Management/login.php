<?php
    /**
     * @author Greg De Vuyst
     */
    if (!isset($_SESSION)) { session_start(); };

    $_SESSION["employee_id"] = "Thomas";
    $_SESSION["isAdmin"] = 1;
    header("Location: deliveries.php");
    exit;

    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");
    require_once(PHPSCRIPTDIR . "db_config.php");
    require_once(PHPSCRIPTDIR . "sanitize.php");

    $error = null;

    // if post request has been sent
    if($_SERVER['REQUEST_METHOD'] == "POST"){





        $_SESSION["employee_id"] = 1;
        $_SESSION["isAdmin"] = 1;
        header("Location: dashboard.php");
        exit;







        // retrieve the POST variables and sanitize them
        $email = sanitize($_POST["email"]);
        $password = sanitize($_POST["password"]);

        $sql = "SELECT * FROM employee WHERE mailAddress = :mail";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':mail', $email);
        if($stmt->execute()){
            // check if employee with given email exists
            if($stmt->rowCount() > 0){
                $employee = $stmt->fetch();
                $hashed_password = $employee['password'];
                // compare hashed password with input password
                if(password_verify($password, $hashed_password)){
                    // add a session variable with the employee's ID
                    $_SESSION['employee_id'] = $employee['id'];
                    // store the access level of the employee
                    $_SESSION['admin'] = ($employee['isAdmin'] == 1) ? true : false;
                    // redirect the user to the dashboard
                    header("Location: dashboard.php");
                }
                else{
                    // invalid password
                    $error = "Incorrect password";
                }

            }
            else{
                $error = "Incorrect email address";
            }
        }
        else{
            $error = "Execution error";
        }
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <title>Login</title>
</head>
<body>
    <div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header><!-- insert header here -->
                                <div id="header-image-container"><img id="header-image" src=<?= HTMLIMAGES . "LOGO_composite.png"; ?> class="img-fluid"></div>
                                <h1><a id="header-title" href="login.php">Login</a></h1>
                            </header>
                        </div>
                    </div>

                    <div class="d-flex flex-column justify-content-center align-items-center h-75">
                        <div class="col-lg-5 col-md-8 col-12 pt-5">

                            <div id="login-image-container" class="text-center">
                                <img id="login-image" src=<?= HTMLIMAGES . "LOGOok.png"; ?> class="img-fluid">
                            </div>

                            <form action="login.php" method="POST" id="login-form" class="d-flex flex-column col-12 pt-3">
                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>

                                    <input type="email" name="email" id="input_email" class="form-control" placeholder="Company Email">
                                </div>

                                <div class="input-group form-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>

                                    <input type="password" name="password" id="input_password" class="form-control" placeholder="Password">
                                </div>

                                <div class="row d-flex flex-row justify-content-between">
                                    <div class="form-check ml-3">
                                        <input type="checkbox" id="input_stayloggedin" class="form-check-input">
                                        <label for="input_stayloggedin" class="form-check-label">Stay logged in?</label>
                                    </div>

                                    <div class="form-group mr-3">
                                        <a id="login-forgot">Forgot password?</a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="login" class="btn btn-primary float-right">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
