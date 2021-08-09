<?php
require 'includes/common.php';
if(!isset($_SESSION['email'])){
    header('location:home.php');
}?>
<!DOCTYPE html>
<html>
    <head>
        <title>New Plan</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';?>
        <div class="container" style="padding-top: 150px;;padding-bottom: 50px;">
            <!--To set new plan panel to center of page-->            
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <!--New plan form panel-->
                    <form class="panel" style="border-color: #398a7b" method="GET" action="plandetails.php">
                        <div class="form-group panel-heading" style="background-color:  #398a7b;color: #f9f9fd;">
                            <center>
                                <h4>Create New Plan</h4>
                            </center>
                        </div>
                        <div id="spacing" class="panel-body">
                            <div class="form-group">
                                <b>Initial Budget:</b>
                                <input type="number" class="form-control" name="budget" 
                                       min="50" placeholder="Initial Budget (Ex. 4000)"
                                       required="true" max="10000000" >
                            </div>
                            <div class="form-group">
                                <b>How many people you want to add in your group ?</b>
                                <input type="number" class="form-control" name="people"
                                       min=1 placeholder="No. of people" required="true" 
                                       max=50>
                            </div>
                            <div class="form-group">
                                <button class="btn form-control" id="button">Next</button>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
        <?php include 'includes/footer.php';
        ?>
    </body>
</html>