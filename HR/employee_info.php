<?php
/**
* Info of a specific Employee
*
* @author Levi Nauwelaerts
* @datetime 25 February 2021
* @input Employee_id given through the url
*/

include './includes/db_config.php';
include './includes/sanitize.php';
include './includes/authentication.php';

 ?>
<?php
$error = null;

//Check the get request for an employee_id, use that id to consult the DB
  if($_SERVER['REQUEST_METHOD'] == "GET"){
    $employee_id = sanitize($_GET["employee_id"]);

    $sql = "SELECT * FROM employee WHERE id = $employee_id";
    $stmt = $db->prepare($sql);
    if($stmt->execute()){
      //check if recieved ID is correct
      if($stmt->rowCount() > 0){
          $employee = $stmt->fetch();

        }
      else $error = "No employee for given ID found.";

    }
    else $error = "Execution error";
}
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
          echo "<title>Employee info ".$employee['id']."</title>";
        ?>
        <link rel="stylesheet" href="./css/reset.css">
    </head>
    <body>
      <table>
        <tr>
          <th>ID</th>
          <!-- Merge firstName + lastName  -->
          <th>Name</th>
          <th>Email</th>
          <th>Phone number</th>
          <th>Salary</th>
          <th>Job</th>
          <th>Birth date</th>
        </tr>
        <tr>
          <?php
          echo "<td>".$employee['id']."</td>";
          echo "<td>".$employee['firstName']." ".$employee['lastName']."</td>";
          echo "<td>".$employee['mailAddress']."</td>";
          echo "<td>".$employee['phoneNumber']."</td>";
          echo "<td>".$employee['salary']."</td>";
          echo "<td>".$employee['job']."</td>";
          echo "<td>".$employee['birthDate']."</td>";
           ?>
        </tr>
      </table>
      <p id="error"><?php echo $error; ?></p>

        <?php include './components/footer.php';?>
    </body>
    </html>
