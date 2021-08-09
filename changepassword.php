<?php
require 'includes/common.php';
if(!isset($_SESSION['email'])){
    header('location:home.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Change Password</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';
         ?>
        <div class="container" style="padding-top: 150px;padding-bottom: 50px;">
            <!--To set change password panel to center of page-->
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <!--Change Password form panel-->
                    <form class="panel" id="form_out_border" method="POST" action="changepassword_script.php">
                        <div class="form-group" id="form_in_border">
                            <center>
                                <h4>Change Password</h4>
                            </center>
                        </div>
                        <div id="spacing">
                            <div class="form-group">
                                <b>Old Password:</b>
                                <input type="password" class="form-control" name="old_password" 
                                       placeholder="Old Password" 
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"                                   
                                       required="true">
                            </div>
                            <div class="form-group">
                                <b>New Password:</b>
                                <input type="password" class="form-control" name="new_password" 
                                       placeholder="New Password (Min. 6 characters)" 
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"                                   
                                       required="true">
                            </div>
                            <div class="form-group">
                                <b>Confirm New Password:</b>
                                <input type="password" class="form-control" name="retype_password" 
                                       placeholder="Re-type New Password" 
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"                                   
                                       required="true">
                            </div>
 
                            <div class="form-group">
                                <button class="btn form-control" style="background-color: #398a7b;color: #f9f9fd">Change</button>
                            </div>
                            <div class="form-group text-warning">
                            => Note : Password should comprise of :- 
                            <ul>
                                <li>Upper Case</li>
                                <li>Lower Case</li>
                                <li>Number or Special Char</li>
                                <li> min 6 Characters</li>
                            </ul>
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