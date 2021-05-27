<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php"); ?>

error_reporting(E_ERROR | E_PARSE);

require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
include(INCLUDESDIR . "db_config.php");
require_once(PHPSCRIPTDIR . "sanitize.php");
require_once(PHPSCRIPTDIR . "authentication.php");
include(COMPONENTSDIR. "navbar.php");

if (!isset($_SESSION)) { session_start(); };


$error = null;
$user_id;
$benefit_id;
$jobdescription_id;
$job_id;
$true = 1;
$false = 0;

if(isset($_POST['Send']))
{
    $title = sanitize($_POST['title']);
    $department = sanitize($_POST['department']);
    $location = sanitize($_POST['location']);
    $available = sanitize($_POST['available']);
    $degree = sanitize($_POST['degree']);
    $experience = sanitize($_POST['experience']);
    $benefit = sanitize($_POST['benefit']);
    $hours = sanitize($_POST['hours']);
    $price = sanitize($_POST['price']);
    $description = sanitize($_POST['description']);
    $date = sanitize($_POST['endDate']);

    $sql = "INSERT INTO `departments`(`name`,`head`, `location`) VALUES (:department,'none',:locations)";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(":department", $department);
    $stmt->bindParam(":locations", $location);

      $result = $stmt->execute();

      if($result){
        $user_id = $db -> lastInsertId();

        $sql = "INSERT INTO `benefits`(`description`) VALUES (:benefit)";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(":benefit", $benefit);



          $result = $stmt->execute();

      }

      if($result){
        $benefit_id = $db -> lastInsertId();

        $sql = "INSERT INTO `job_descriptions`(`degree`, `experience`, `general`, benefits) VALUES (:degree,:experience,:descriptions,".$benefit_id.")";
        $stmt = $db->prepare($sql);

        $stmt->bindParam(":degree", $degree);
        $stmt->bindParam(":experience", $experience);
        $stmt->bindParam(":descriptions", $description);


          $result = $stmt->execute();

      }

      if($result){
        $jobdescription_id = $db -> lastInsertId();

        $sql = "INSERT INTO `jobs`(`id`, `name`, `departmentID`, `available`, `description`,`hours`,`pricePerHour` ) VALUES (".$user_id.",:title,".$user_id.",:available,".$jobdescription_id.",:hours,:price)";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":title", $title);
        if($available){
            $stmt->bindParam(":available", $true);
        }else{
            $stmt->bindParam(":available", $false);

        }
        $stmt->bindParam(":hours", $hours);
        $stmt->bindParam(":price", $price);

          $result = $stmt->execute();

      }
      if($result){
        $job_id = $db -> lastInsertId();

        $sql = "INSERT INTO `job_offers`(`jobID`, `creationDate`, `descriptionID`) VALUES (".$job_id.",:date,".$jobdescription_id.")";

        $stmt = $db->prepare($sql);

        $stmt->bindParam(":date", $date);


          $result = $stmt->execute();

      }




}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "vacature.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

    <title>Add Vacature</title>
</head>
<body>
<?php echo generateNavigationBar("Add Vacature", "/app2/hr/vacature", getEmployeeFirstName()) ?>
    <div class="add-container">
            <form action="" method="POST">

                <div class="row">
                    <label for="">Job Title</label><br>
                    <input type="text" placeholder="title" name="title" id="title">
                </div>
                <div class="row">
                    <label for="">Department</label><br>
                    <input type="text" placeholder="HR" name="department" id="department">
                </div>
                <div class="row">
                    <label for="">Location</label><br>
                    <input type="text" placeholder="Belgium" name="location" id="location">
                </div>
                <div class="row">
                    <label for="">Job creation Date</label><br>
                    <input type="date" name="endDate" id="end">
                </div>
                <div class="row">
                    <label for="">Is this Job Available ?<input type="checkbox" name="available" id="available"></label>
                </div>
                <div class="row">
                    <label for="">Degree</label><br>
                    <input type="text" placeholder="E-ICT Batchler" name="degree" id="degree">
                </div>
                <div class="row">
                    <label for="">Experience</label><br>
                    <input type="text" placeholder="2 years junior developer" name="experience" id="experience">
                </div>
                <div class="row">
                    <label for="">benefits</label><br>
                    <input type="text" placeholder="Company Car" name="benefit" id="experience">
                </div>
                <div class="row">
                    <label for="">Work Hours</label><br>
                    <input type="text" placeholder="06u00 - 14u30" name="hours" id="experience">
                </div>
                <div class="row">
                    <label for="">PricePerHour</label><br>
                    <input type="text" placeholder="14.59" name="price" id="experience">
                </div>
                <div class="row" id="reason">
                    <label for="">General Job Description</label><br>
                    <textarea name="description" placeholder="give a general description of the job" id="description" cols="30" rows="2" spellcheck="false"></textarea>
                </div>
                <div class="row">
                    <input type="submit" value="Send" name="Send" id="sentBtn">
                </div>
            </form>

        </div>
</body>
