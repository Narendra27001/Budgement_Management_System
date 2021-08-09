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
        <title>Expense Distribution</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';
        //Query to fetch plan details
        unset($_SESSION['plan_id']);
        $view_plans_members = "select title,people_number,initial_budget,"
                . "remaining from plans_members pm inner join members m"
                . " on pm.member_id = m.id inner join plans p on pm.plan_id= p.id"
                . " where pm.plan_id = $plan_id";
        $view_plans_members_result = mysqli_query($con, $view_plans_members);
        if($view_plans_members_result){
        while($row = mysqli_fetch_array($view_plans_members_result)){
            $title = $row['title'];
            $people = $row['people_number'];
            $initial_budget = $row['initial_budget'];
            $remaining = $row['remaining'];
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
                            <div class="row"  style="padding-bottom:10px;">
                                <div class="col-sm-3">
                                    <b>Initial Budget:</b>
                                </div>
                                <div class="col-sm-4 col-sm-offset-5" style="text-align: right;">
                                    <b>&#8377 <?php echo $initial_budget;?></b>
                                </div>
                            </div>
                            <?php
                                    $total =0;
                                    //Query to fetch members and amount spent by each member in a plan
                                    $view_name_amount = "select member_name,spent "
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
                                    &#8377 <?php $money = $row_name_amount['spent'];
                                        $total+=$money;
                                        echo $money;
                                    ?>
                                </div>
                            </div>
                                    <?php }?>
                            <div class="row"  style="padding-bottom:10px;">
                                <div class="col-sm-4">
                                    <b> Total Amount Spent:</b>
                                </div>
                                <div class="col-sm-4 col-sm-offset-4" style="text-align: right;">
                                    <b>&#8377 <?php
                                    echo $total;?></b>
                                </div>
                            </div>
                            <div class="row"  style="padding-bottom:10px;">
                                <div class="col-sm-4">
                                    <b>Remaining Amount:</b>
                                </div>                                
                                <div class="col-sm-4 col-sm-offset-4" style="text-align: right;
                                <?php $remaining=$initial_budget-$total;
                                if($remaining>0){?>                                     
                                     color: green;
                                     <?php }
                                     else if($remaining < 0){?>
                                     color: red;
                                     <?php }?>"><b>
                                    &#8377 <?php echo $remaining;
                                    //Query to update balance amount left in the plan
                                    $update_remaining = "update plans set "
                                            . "remaining='$remaining' where plans.id = $plan_id";
                                    $update_remaining_result = mysqli_query($con, $update_remaining);
                                    if($update_remaining_result){?>
                                    </b></div>
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
                                <?php $share = $row_name['spent']-$individual_shares;
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
        <?php }
        else{
            echo "<script>alert('Some error occurred while updating balance')</script>";
            echo "<script>location.href='home.php'</script>";                                        
        }
        }
        else{
            echo "<script>alert('Some error occurred while loading plan')</script>";
            echo "<script>location.href='home.php'</script>";                                        
        }
        include 'includes/footer.php';?>
    </body>
</html>