<?php
require 'includes/common.php';
if(isset($_SESSION['email'])){
    header('location:home.php');
}?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';?>
        <div class="container" style="padding-top: 150px;padding-bottom: 50px;">
            <!--To set login panel to center of page-->
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <!--Login form panel-->
                    <form class="panel" id="form_out_border" method="POST" action="login_script.php">
                        <div id="form_in_border" class="form-group">
                            <center>
                                <h4>Login</h4>
                            </center>
                        </div>
                        <div id="spacing">
                            <div class="form-group">
                                <b>Email:</b>
                                <input type="email" class="form-control" name="email" 
                                       placeholder="Enter Valid Email" required="true">
                            </div>
                            <div class="form-group">
                                <b>Password:</b>
                                <input type="password" class="form-control" name="password"
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"                                                                      
                                       placeholder="Password (Min. 6 characters)" required="true">
                            </div>           
                            <div class="form-group">
                                <button class="btn form-control" style="background-color:#398a7b;color: #f9f9fd;">Login</button>
                            </div>
                        </div>
                        <div class="panel-footer">
                            Don't have an account? <a href="signup.php"> Click here to Sign Up</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include 'includes/footer.php';
        ?>
    </body>
</html>