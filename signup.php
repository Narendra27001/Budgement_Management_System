<?php
require 'includes/common.php';
if(isset($_SESSION['email'])){
    header('location:home.php');
}?>
<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';?>
        <div class="container" style="padding-top: 150px;padding-bottom:50px; ">
            <!--To set sign up panel to center of page-->
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <!--Sign Up form panel-->
                    <form class="panel" id="form_out_border" method="POST" action="signup_script.php">
                        <div class="form-group" id="form_in_border">
                            <center>
                                <h4>Sign Up</h4>
                            </center>
                        </div>
                        <div id="spacing">
                            <div class="form-group">
                                <b>Name:</b>
                                <input type="text" class="form-control" name="name"
                                       placeholder="Name" required="true">
                            </div>
                            <div class="form-group">
                                <b>Email:</b>
                                <input type="email" class="form-control" name="email"
                                       placeholder="Enter Valid Email" required="true">
                            </div>
                            <div class="form-group">
                                <b>Password:</b>
                                <input type="password" class="form-control" name="password" 
                                       placeholder="Password (Min. 6 characters)" 
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"                                   
                                       required="true">

                            </div>
                            <div class="form-group">
                                <b>Phone Number:</b>
                                <input type="tel" class="form-control" name="phone_number" 
                                       placeholder="Enter Valid Phone Number (Ex: 844844850)"
                                       maxlength="10" pattern="[789][0-9]{9}" required="true">
                            </div>                        
                            <div class="form-group">
                                <button class="btn form-control" style="background-color: #398a7b;color: #f9f9fd">Sign Up</button>
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
                            <div class="form-group text-warning">
                            => Please enter a valid Indian contact number.
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
        <?php include 'includes/footer.php';?>
    </body>
</html>