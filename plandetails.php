<?php
require 'includes/common.php';
if(!isset($_SESSION['email'])){
    header('location:home.php');
}?>
<!DOCTYPE html>
<html>
    <head>
        <title>Plan Details</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id='webpage_color'>
        <?php include 'includes/header.php';?>
        <div class="container" style="padding-top: 150px;;padding-bottom: 50px;">
            <!--To set plan details form to center of page-->            
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="panel">
                        <div class="panel-body">
                            <!--Form to fill more details of the plan--> 
                            <form method="POST" action="plandetails_script.php">
                                <div class="form-group">
                                    Title:<br>
                                    <input type="text" name="title" class="form-control" 
                                           placeholder="Enter Title (Ex. Trip to Goa)" 
                                           required="true">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            From:<br>
                                            <input type="date" class="form-control" 
                                                   name="from" min="2020-01-01" 
                                                   max="2020-12-31" required="true">
                                        </div>
                                        <div class="col-sm-6">
                                            To:<br>
                                            <input type="date" class="form-control" 
                                                   name="to" min="2020-01-01"
                                                   max="2020-12-31" required="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            Initial Budget:<br>
                                            <input type="text" name="initial_budget" 
                                                   class="form-control" value="<?php 
                                                   $budget = $_GET['budget'];
                                                   echo $budget;?>" readonly="true">
                                        </div>
                                        <div class="col-sm-4">
                                            No. of people:<br>
                                            <input type="text" name="people_number" 
                                                   class="form-control" value="<?php 
                                                   $people = $_GET['people'];
                                                   echo $people;?>" readonly="true">
                                        </div>
                                    </div>
                                </div>
                                <?php for($i=1;$i<=$people;$i++){?>
                                <div class="form-group">
                                    Person <?php echo $i?>:<br>
                                    <input type="text" name="person_name_<?php echo $i?>" class="form-control" 
                                           placeholder="Person <?php echo $i?> Name" 
                                           required="true">
                                </div>
                                <?php }?>
                                <div class="form-group">
                                <button class="btn form-control" id="button">Submit</button>
                                </div>                                           
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'includes/footer.php';
        ?>
    </body>
</html>