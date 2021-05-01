<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/PATHS.PHP");

    include './includes/db_config.php';
    include './includes/sanitize.php';
    include "components/check_db.php"; // check if the foreig keys have been set
    // add a new user
    $msg = "";
    $err = FALSE;
    // if post request has been sent
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        // retrieve the POST variables and sanitize them
        $fName = sanitize($_POST['fName']);
        $lName = sanitize($_POST['lName']);
        $email = sanitize($_POST['email']);
        $password = sanitize($_POST['password']);
        $bod = $_POST['dob'];
        $pnum = $_POST['pnum'];
        $sal = $_POST['sal'];
        $job = $_POST['job'];
        $admin = $_POST['admin'];
        $id = 1;

        // add a new user
    $password = password_hash("password",PASSWORD_DEFAULT);
    $sql = "SELECT * FROM employee;";
    $result = mysqli_query($link,$sql);

        while(($row = mysqli_fetch_array($result))){
            if($id == $row['id']){
                $id++;
            }
            if($email == $row['mailAddress']){
                
                $msg = "This email is already in use !";
                $err = TRUE;
            }
        }

    if($err == FALSE){
        $sql = "INSERT INTO employee(id,firstName,lastName,mailAddress,password,birthDate,phoneNumber,salary,job,isAdmin) VALUES($id,\"$fName\",\"$lName\",\"$email\",\"$password\",\"2000-03-21\",$pnum,$sal,$job,$admin);";
        $msg = "Query complete";
    }
    mysqli_query($link,$sql);
    mysqli_close($link);
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_HEAD); ?>
    <script src=<?= HTMLJAVASCRIPT . "expandrow.js"; ?>></script>
    <script src=<?= HTMLJAVASCRIPT . "cleanForm.js"; ?>></script>
    <title>Deliveries</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_BODY_TOP); ?>
    <div class="col-lg-12 pt-3 g-0">
        <h2>Add a new employee</h2>                    
            <div class="flex-container">
                <div>
                    <form action="" method="POST">
                        <div class="form-row col-lg-8 col-12">
                            <div class="form-group col-4">
                                <input type="text" name="fName" id="" placeholder="First Name" class="form-control">
                            </div>

                            <div class="form-group col-4">
                                <input type="text" name="lName" id="" placeholder="Last Name" class="form-control">
                            </div>

                            <div class="form-group col-4">
                                <input type="text" name="dob" id="" placeholder="Date of birth" class="form-control">
                            </div>
                        </div>

                        <div class="form-row col-lg-8 col-12">
                            <div class="form-group col-4">
                                <input type="text" name="email" id="" placeholder="E-mail" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <input type="tel" name="pnum" id="" placeholder="Phonenumber" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <input type="password" name="password" id="" placeholder="password" class="form-control">
                            </div>
                        </div>

                        <div class="form-row col-lg-8 col-12">
                            <div class="form-group col-4">
                                <input type="text" name="sal" id="" placeholder="Salary" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <input type="text" name="job" id="" placeholder="Job ID (1 for now)" class="form-control">
                            </div>
                            <div class="form-group col-4">
                                <div class="form-check pl-4 pt-2">
                                    <input name="admin" type="checkbox" class="form-check-input">
                                    <label class="form-check-label" for="admin">Admin</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row col-lg-8 col-12">
                            <div class="form-group col-4">
                                <button type="submit" value="save" class="btn btn-success form-control">Submit</button>
                                <p id="error"><?php echo $msg; ?></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </h2>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>