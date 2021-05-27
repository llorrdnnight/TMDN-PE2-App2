<?php
    /**
    * Info of all Employee
    *
    * Yannick Fauche
    * datetime 13 February 2021
    * Employee list
    */

    //TODO: fix die connect file terug, want anders werkt er hier niks. of begin gewoon de api te gebruiken

    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    if (!isset($_SESSION)) { session_start(); };

    //include 'connect.php'; //← ← ← kan deze file nergens vinden

    if(isset($_POST['submit']))
    {
        $sql = "SELECT * FROM employee WHERE firstName LIKE '%".$_POST["firstname"]."%'";

        // echo $sql;
        // $result = $db->query($sql);

        //echo "<div><table class='usertable'><th colspan=8>Employees<form action='showallusers.php' method='post'>
        //Search Name: <input type='text' name='firstname' />
        //<input type='submit' name='submit' value='Submit' />
        ///</form></th><tr id='fix'><td><b>Id</b></td><td><b>Name</b></td><td><b>Lastname</b></td><td><b>Email</b></td><td><b>Phone</b><td><b>Salary</b></td><td><b>birthDate</b></td><td><b>Manage</b></td><tr>";

        //     echo"<tr><td>".$row['id']."</td><td><a href=employee_info.php?employee_id=".$row['id'].">".$row['firstName']."</a></td><td>".$row['lastName']."</td><td>".$row['mailAddress']."</td><td>".$row['phoneNumber']."</td><td>".$row['salary']."</td><td>".$row['birthDate']."</td><td><a href=delete.php?delete=".$row['id']."><img class='resize' src='../images/delete.png'></a><a href=manage.php?edit=".$row['id']."> <img class='resize' src='../images/manage.png'></a></td></tr>";
        // }

        // echo"</table></div>";
        // echo '';
    }
    else
    {
        $sql = "SELECT * FROM employee";
        // $result = $db->query($sql);

        // while($row = $result->fetch_assoc()){
        // }

        // echo"</table></div>";
        // echo '<center><br><a href="useradd.php"><img id="plus" src="../images/adduser.jpg"></a><br><a href="admin.php" class="buttton back"><p class="backtext">Go back</p></a></center>';
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_HRHEAD); ?>
    <title>Employee Info</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_HR_BODY_TOP); ?>
        <table class='usertable'>
            <th colspan=8>Employees
                <form action='showallusers.php' method='post'>
                    Search: <input type='text' name='firstname' />
                    <input type='submit' name='submit' value='Submit' />
                </form>
            </th>

            <tr id='fix'>
                <td><b>Id</b></td>
                <td><b>Name</b></td>
                <td><b>Lastname</b></td>
                <td><b>Email</b></td>
                <td><b>Phone</b></td>
                <td><b>Salary</b></td>
                <td><b>birthDate</b></td>
                <td><b>Manage</b></td>
            <tr>

            <?php while($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><a href=<?= "employee_info.php?employee_id=".$row['id']; ?>><?= $row['firstName']; ?></a></td>
                    <td><?= $row['lastName']; ?></td>
                    <td><?= $row['mailAddress']; ?></td>
                    <td><?= $row['phoneNumber']; ?></td>
                    <td><?= $row['salary']; ?></td>
                    <td><?= $row['birthDate']; ?></td>
                    <td>
                        <a href=<?= "delete.php?delete=".$row['id']; ?>><img src=<?= HTMLIMAGES . "delete.png"; ?>></a>
                        <a href=<?= "manage.php?edit=".$row['id']; ?>><img src=<?= HTMLIMAGES . "manage.png"; ?>></a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <a href="useradd.php"><img src=<?= HTMLIMAGES . "adduser.jpg"; ?>></a>
        <a href="admin.php"><p>Go back</p></a>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
