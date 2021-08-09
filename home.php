<?php
require 'includes/common.php';
if(!isset($_SESSION['email'])){
    header('location:login.php');
}?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';
        include 'includes/functions.php';
        $user_id = $_SESSION['id'];
        $view_plan = "CALL `get_plan`('$user_id') ";
        $view_plan_result = mysqli_query($con, $view_plan);
        if(mysqli_num_rows($view_plan_result)==0){?>
        <!--TO display 'create a new plan' panel when there are zero plans of a user-->
        <div class="container" style="padding-top: 150px;padding-bottom: 50px;">
            <div class="row">
                <div class="col-sm-offset-1">
                    <h2>You don't have any active plans</h2><br><br><br>                    
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    <div class="panel">
                        <div class="panel-body" style="color: #abbfd1">
                            <center><br><br><br><br><br><br>
                                <a href="newplan.php" class="link">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Create a New Plan</a>
                            </center><br><br><br><br><br><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{ ?>
        <!--To display the all the plans of a user when there are one or more plans of that user-->
        <div class="container" style="padding: 100px 0;">
            <div class="row">
                <div class="col-sm-3 col-sm-offset-1">
                    <h2> Your Plans</h2><br>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <?php while ($row = mysqli_fetch_array($view_plan_result)){
                        $id = $row['id'];?>
                    <div class="col-sm-3 col-sm-offset-1">
                        <!--Panel design to view each a short glimpse of an individual plan-->
                        <div class="panel">
                            <div class="panel-heading" style="background-color:  #398a7b;color: #f9f9fd;">
                                <div class="row">
                                    <div class="col-sm-7 col-sm-offset-2">
                                        <h4><?php echo $row['title'];?></h4>
                                    </div>
                                    <div class="col-sm-3" style="text-align: right;">
                                        <h4><span class="glyphicon glyphicon-user"></span> <?php echo $row['people_number'];?></h4>                                        
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row"  style="padding-bottom:10px;">
                                    <div class="col-sm-6">
                                        Budget:
                                    </div>
                                    <div class="col-sm-6" style="text-align: right;">
                                        &#8377 <?php echo $row['initial_budget'];?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2">
                                        Date:
                                    </div>
                                    <div class="col-sm-10"  style="text-align: right;">
                                        <?php
                                        $from = $row['from_date'];
                                        $to = $row['to_date'];
                                        echo day($from)." ".month($from)." -".day($to)." ".month($to).year($to);?>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="padding-bottom:10px;">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <a href="viewplan.php?plan_id=<?php echo $id;?>" class="btn form-control" id="button">View Plan</a>                                                                    
                                </div>
                            </div>                            
                        </div>                        
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
        <!--Tool to create a new plan when the user already has atleast one plan-->
        <div  id="new_plan">
            <a href="newplan.php"><span class="glyphicon glyphicon-plus-sign" style="color:#398a7b;background-color:#f9f9fd;"></span></a>
        </div>
        <?php }
        include 'includes/footer.php';
        ?>
    </body>
</html>