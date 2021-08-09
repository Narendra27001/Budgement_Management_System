<?php
    require 'includes\common.php';
    if (isset($_SESSION['email'])) { 
    header('location: home.php');
    }
?>
<!DOCTYPE html>
<html> 
    <head>
        <title>Ct&#8377l Budget</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php include 'includes/header.php'; 
        ?>
            <!--Division to add background image-->
        <div id="bannerImage">
            <!--Division to add 'start today' banner-->
            <div class="container">
                <center>
                    <div id="bannerContent">
                        <h1>We help you control your budget</h1><br><br>
                        <a href="login.php" class="btn btn-lg active" 
                           style="background-color:  #398a7b;color: #f9f9fd;">
                            Start Today</a>
                    </div>
                </center>
            </div>
        </div>
        <?php include 'includes/footer.php';
        ?>
    </body>
</html>