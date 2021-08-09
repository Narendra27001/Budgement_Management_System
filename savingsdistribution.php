<?php
require 'includes/common.php';
if(!isset($_SESSION['email'])){
    header('location:home.php');
}
$plan_id = $_GET['plan_id'];
$select_user="select * from users_plans up where up.plan_id=$plan_id";
$select_user_result= mysqli_query($con, $select_user);
$row_user= mysqli_fetch_array($select_user_result);
if($_SESSION['id']!=$row_user['user_id']){
    header('location:home.php');
}
 $_SESSION['plan_id']=$plan_id;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Savings Distribution</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';
            unset($_SESSION['plan_id']);
        //Query to fetch plan details
        $view_plans_members = "select title,people_number from plans_members pm "
                . "inner join members m on pm.member_id = m.id inner join plans p "
                . "on pm.plan_id= p.id where pm.plan_id = $plan_id";
        $view_plans_members_result = mysqli_query($con, $view_plans_members);
        if($view_plans_members_result){
        while($row = mysqli_fetch_array($view_plans_members_result)){
            $title = $row['title'];
            $people = $row['people_number'];
        }?>
        <div class="container" style="padding-top: 150px;padding-bottom: 50px;">
            <!--To set the expense distribution panel to the center of page-->
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <!--Expense Distribution Panel-->
                    <div class="panel">
                        <div class="panel-heading" style="background-color: #398a7b;color: #f9f9fd;">
                            <div class="row">
                                <div class="col-sm-5 col-sm-offset-4">
                                    <h4><?php echo $title;?></h4>
                                </div>
                                <div class="col-sm-3" style="text-align: right;">
                                    <h4><span class="glyphicon glyphicon-user"></span>
                                    <?php echo $people;?></h4>                                        
                                </div>            
                            </div>
                        </div>
                        <div class="panel-body">
                            <?php
                                    $total =0;
                                    //Query to fetch members and amount spent by each member in a plan
                                    $view_name_amount = "select member_name,saved "
                                            . "from plans_members pm inner join "
                                            . "members m on pm.member_id = m.id "
                                            . "inner join plans p on pm.plan_id= p.id "
                                            . "where pm.plan_id = $plan_id";
                                    $view_name_amount_result = mysqli_query($con, $view_name_amount);
                                    while($row_name_amount = mysqli_fetch_array($view_name_amount_result)){?>
                            <div class="row"  style="padding-bottom:10px;">
                                <div class="col-sm-4">
                                    <b><?php echo $row_name_amount['member_name'];?> :</b>
                                </div>
                                <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
                                    &#8377 <?php $money = $row_name_amount['saved'];
                                        $total+=$money;
                                        echo $money;
                                    ?>
                                </div>
                            </div>
                                    <?php }?>
                            <div class="row"  style="padding-bottom:10px;">
                                <div class="col-sm-4">
                                    <b> Total Amount Saved:</b>
                                </div>
                                <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
                                    <b>&#8377 <?php
                                    echo $total;?></b>
                                </div>
                            </div>
                            <div class="row"  style="padding-bottom:10px;">
                                <div class="col-sm-4">
                                    <b>Individual Shares:</b>
                                </div>
                                <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
                                    &#8377 <?php
                                    echo $individual_shares = $total/$people;?>
                                </div>
                            </div>
                            <?php
                            //Query to fetch members and amount spent by each member 
                            //in a plan in order to calculate individual share
                                    $view_names_result = mysqli_query($con, $view_name_amount);
                                    while($row_name = mysqli_fetch_array($view_names_result)){?>
                            <div class="row"  style="padding-bottom:10px;">
                                <div class="col-sm-4">
                                    <b><?php echo $row_name['member_name'];?> :</b>
                                </div>
                                <div class="col-sm-8" style="text-align: right;
                                <?php $share = $row_name['saved']-$individual_shares;
                                if($share>0){?>
                                     color: green;">
                                     <?php echo "Gets back";?> &#8377 <?php echo $share;
                                     }else if($share<0){?>
                                     color: red;">
                                     <?php echo "Owes";?> &#8377 <?php echo $share*(-1);
                                     }else{?>
                                     color: black;">
                                     All Settled up
                                     <?php }?>
                                </div>
                            </div>
                                    <?php } ?>
                            <div class="form-group"><center>
                                    <a href="viewplan.php?plan_id=<?php echo $plan_id?>" 
                                       class="btn" id="button">
                                        <span class="glyphicon glyphicon-arrow-left">
                                        </span> Go Back</a></center>
                            </div>                                                                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        }
        else{
            echo "<script>alert('Some error occurred while loading plan')</script>";
            echo "<script>location.href='home.php'</script>";                                        
        }
        include 'includes/footer.php';?>
    </body>
</html>