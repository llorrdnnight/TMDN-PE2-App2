
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/vacature.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

    <title>Add Vacature</title>
</head>
<body>
<div class="nav-bar">
            <div class="left">
                <a href="dashboard.php"><i class="fas fa-arrow-left"></i></a>
                <h1>Add Vacature</h1>
            </div>
            <div class="right">
            <i class="fa fa-user-circle"></i>
            <span>John Doe</span>
            </div>
        </div>
        <div class="add-container">
            <form action="" method="POST">
                         
                <div class="row">
                    <label for="">Job Title</label><br>
                    <input type="text" value="title" name="" id="title">
                </div>
                <div class="row">
                    <label for="">Department</label><br>
                    <input type="text" value="HR" name="" id="department">
                </div>
                <div class="row">
                    <label for="">Location</label><br>
                    <input type="text" value="Belgium" name="" id="location">
                </div>
                <div class="row">
                    <label for="">Job creation Date</label><br>
                    <input type="date" name="endDate" id="end">
                </div>
                <div class="row">
                    <label for="">Is this Job Available ?<input type="checkbox" name="" id="available"></label>
                </div>
                <div class="row">
                    <label for="">Degree</label><br>
                    <input type="text" value="E-ICT Batchler" name="" id="degree">
                </div>
                <div class="row">
                    <label for="">Experience</label><br>
                    <input type="text" value="2 years junior developer" name="" id="experience">
                </div>
                <div class="row" id="reason">
                    <label for="">General Job Description</label><br>
                    <textarea name="reason" placeholder="give a general description of the job" id="" cols="30" rows="2" spellcheck="false"></textarea>
                </div>
                <div class="row">
                    <input type="submit" value="Send">
                </div>
            </form>
            
        </div>
    </div>
