<?php
require 'includes/common.php';
if(!isset($_SESSION['email'])){
    header('location:login.php');
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
        <title>View Plan</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .button{
                border-color: #398a7b;
                color: #398a7b;                
            }
            .button:hover{
                background-color: #398a7b;
                color: #f9f9fd;
            }
        </style>        
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';
        include 'includes/functions.php';
        unset($_SESSION['plan_id']);
        $total=0;
        //Query to view the selected plan
        $view_plan = "select * from plans p where p.id = $plan_id ";
        $view_plan_result = mysqli_query($con, $view_plan);
        if($view_plan_result){
            $view_member = "select member_id,member_name from plans_members pm"
                    . " inner join members m on pm.member_id = m.id where"
                    . " pm.plan_id = $plan_id";
            $view_member_result = mysqli_query($con, $view_member);
            $view_member_savings_result = mysqli_query($con, $view_member);
            $view_savings_total = "select savings_amount from "
                    . "members_savings ms inner join members m on"
                    . " ms.member_id = m.id inner join savings s on "
                    . "ms.savings_id = s.id inner join plans_members pm on"
                    . " m.id=pm.member_id where pm.plan_id = $plan_id";
            $view_savings_total_result = mysqli_query($con, $view_savings_total);
            while($row_name_amount = mysqli_fetch_array($view_savings_total_result)){
                $money = $row_name_amount['savings_amount'];
                $total+=$money;                
            }            
            while ($row_plan = mysqli_fetch_array($view_plan_result)){
                $plan_title = $row_plan['title'];
                $people_number = $row_plan['people_number'];
                $initial_budget = $row_plan['initial_budget'];
                $remaining = $row_plan['remaining'];
                $from = $row_plan['from_date'];
                $to = $row_plan['to_date'];
            }
        }
        else{
            echo "<script>alert('Some error occurred while loading plans')</script>";
            echo "<script>location.href='home.php'</script>";                            
        } ?>
        <div class="container" style="padding-top: 150px; padding-bottom: 50px;">
            <div>
                <!--To allot top left corner to view the plan -->
                <div class="row">
                    <div class="col-sm-6">
                        <!--Panel to view a short glimpse of the selected plan-->
                        <div class="panel">
                            <div class="panel-heading" style="background-color:#398a7b;
                                 color: #f9f9fd;">
                                <div class="row">
                                    <div class="col-sm-5 col-sm-offset-4">
                                        <h4><?php 
                                        echo $plan_title;?></h4>
                                    </div>
                                    <div class="col-sm-3" style="text-align: right;">
                                                <h4><span class="glyphicon glyphicon-user">
                                            </span> <?php echo $people_number;?></h4>                                  
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row"  style="padding-bottom:10px;">
                                    <div class="col-sm-3">
                                        Budget:
                                    </div>
                                    <div class="col-sm-4 col-sm-offset-5" 
                                         style="text-align: right;">
                                        &#8377 <?php echo $initial_budget;?>
                                    </div>
                                </div>
                                <div class="row"  style="padding-bottom:10px;">
                                    <div class="col-sm-4">
                                        Remaining Amount:
                                    </div>
                                        <?php 
                                        if($remaining>0){?>
                                    <div class="col-sm-4 col-sm-offset-4" 
                                         style="text-align: right;color: green;">
                                        &#8377 <?php echo $remaining;?>                                    
                                    </div>
                                        <?php }else if($remaining<0){?>
                                    <div class="col-sm-4 col-sm-offset-4" 
                                         style="text-align: right;color: red;">
                                        &#8377 <?php echo $remaining;?>               
                                    </div>
                                        <?php }else{?>
                                    <div class="col-sm-4 col-sm-offset-4" 
                                         style="text-align: right;">
                                        &#8377 <?php echo $remaining;?>               
                                    </div>
                                        <?php }?>
                                </div>
                                <div class="row"  style="padding-bottom:10px;">
                                    <div class="col-sm-3">
                                        Total Savings:
                                    </div>
                                    <div class="col-sm-4 col-sm-offset-5" 
                                         style="text-align: right;color: green;">
                                        &#8377 <?php echo $total;?>
                                    </div>
                                </div>                                
                                <div class="row">
                                    <div class="col-sm-5">
                                        Date:
                                    </div>
                                    <div class="col-sm-7" style="text-align: right;">
                                            <?php
                                            echo day($from)." ".month($from)." -"
                                                    .day($to)." ".month($to).year($to);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--To allot top right corner for  the expense distribution link and savings distribution link-->
                    <div class="col-sm-4 col-sm-offset-2"><br><br><br>
                        <!--Hyperlink to view complete distribution of the expenses 
                        of each member in a selected plan-->
                        <div class="form-group">
                            <a href="expensedistribution.php?plan_id=<?php 
                            echo $plan_id;?>" class="btn button">Expense Distribution</a>
                        </div>
                        <!--Hyperlink to view complete distribution of the savings 
                        of each member in a selected plan-->                        
                        <div class="form-group">
                            <a href="savingsdistribution.php?plan_id=<?php 
                            echo $plan_id;?>" class="btn button">Savings Distribution</a>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <!--To set bottom left corner to view all the expenses in a plan-->
                    <div class="col-sm-6">
                    <?php
                    //Query to select all the expenses present in a selected plan
                    $view_expense = "select expense_id,expense_title,expense_amount,member_name,"
                            . "expense_date,expense_image from members_expenses "
                            . "me inner join members m on me.member_id = m.id "
                            . "inner join expenses e on me.expense_id = e.id "
                            . "inner join plans_members pm on m.id=pm.member_id where pm.plan_id = $plan_id";
                    $view_expense_result = mysqli_query($con, $view_expense);
                    while($row_expense = mysqli_fetch_array($view_expense_result)){?>
                        <div class="col-sm-6">
                            <div class="panel">
                                <!--Panel to display each individual expense-->
                                <div class="panel-heading" style="background-color:#398a7b;
                                     color: #f9f9fd;">
                                    <center>
                                        <h4><?php echo $row_expense['expense_title'];?></h4>
                                    </center>
                                </div>
                                <div class="panel-body">
                                    <div class="row"  style="padding-bottom:10px;">
                                        <div class="col-sm-6">
                                        Amount Spent:
                                        </div>
                                        <div class="col-sm-6" style="text-align: right;">
                                            &#8377 <?php echo $row_expense['expense_amount'];?>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-bottom:10px;">
                                        <div class="col-sm-5">
                                            Paid by:
                                        </div>
                                        <div class="col-sm-7"  style="text-align: right;">
                                        <?php echo $row_expense['member_name'];?>
                                        </div>
                                    </div>                            
                                    <div class="row">
                                        <div class="col-sm-5">
                                            Paid on:
                                        </div>
                                        <div class="col-sm-7"  style="text-align: right;">
                                        <?php $expense_date = $row_expense['expense_date'];
                                            echo day($expense_date)." ".month($expense_date)
                                                    ." ".year($expense_date);?>
                                            </div>
                                        </div>
                                    <div class="row"><br>
                                    <?php $image = $row_expense['expense_image'];
                                    if($image == "blank"){?>
                                        <center><a href="#" class="link">You don't 
                                                    have bill</a></center>
                                            <?php } else {?>
                                        <center><a href="<?php echo $image;?>" 
                                                   target="_blank" class="link">Show bill
                                            </a></center> 
                                            <?php }?>
                                    </div>
                                    <div class="row" style="padding-top:20px;">
                                <div class="col-sm-8 col-sm-offset-2">
                                    <a href="delete.php?type=expenses&id=<?php echo $row_expense['expense_id'];?>" 
                                       class="btn form-control" id="button">Delete</a>                                                                    
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>
                            <?php }
                    //Query to select all the savings present in a selected plan
                    $view_savings = "select savings_id,savings_title,savings_amount,member_name,"
                            . "savings_date from members_savings "
                            . "ms inner join members m on ms.member_id = m.id "
                            . "inner join savings s on ms.savings_id = s.id "
                            . "inner join plans_members pm on m.id=pm.member_id where pm.plan_id = $plan_id";
                    $view_savings_result = mysqli_query($con, $view_savings);
                    while($row_savings = mysqli_fetch_array($view_savings_result)){?>
                        <div class="col-sm-6">
                            <div class="panel">
                                <!--Panel to display each individual savings-->
                                <div class="panel-heading" style="background-color:#398a7b;
                                     color: #f9f9fd;">
                                    <center>
                                        <h4><?php echo $row_savings['savings_title'];?></h4>
                                    </center>
                                </div>
                                <div class="panel-body">
                                    <div class="row"  style="padding-bottom:10px;">
                                        <div class="col-sm-7">
                                        Amount Saved:
                                        </div>
                                        <div class="col-sm-5" style="text-align: right;">
                                            &#8377 <?php echo $row_savings['savings_amount'];?>
                                        </div>
                                    </div>
                                    <div class="row" style="padding-bottom:10px;">
                                        <div class="col-sm-5">
                                            Saved by:
                                        </div>
                                        <div class="col-sm-7"  style="text-align: right;">
                                        <?php echo $row_savings['member_name'];?>
                                        </div>
                                    </div>                            
                                    <div class="row">
                                        <div class="col-sm-5">
                                            Saved on:
                                        </div>
                                        <div class="col-sm-7"  style="text-align: right;">
                                        <?php $savings_date = $row_savings['savings_date'];
                                            echo day($savings_date)." ".month($savings_date)
                                                    ." ".year($savings_date);?>
                                            </div>
                                    </div>
                                    <br><br>
                                    <div class="row" style="padding-top:20px;">
                                        <div class="col-sm-8 col-sm-offset-2">
                                        <a href="delete.php?type=savings&id=<?php echo $row_savings['savings_id'];?>" 
                                           class="btn form-control" id="button">Delete</a>                                                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <?php }?>                        
                    </div>
                    <!--To allot bottom right corner for add expense form-->
                    <div class="col-sm-5 col-sm-offset-1">
                        <!--Add expense form panel-->
                        <div class="panel">
                            <div class="panel-heading" 
                                 style="background-color:#398a7b;color: #f9f9fd;">
                                <div class="row"><center>
                                        <h4>Add New Expense</h4></center>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form method="POST" action="addexpense.php?plan_id=<?php 
                                echo $plan_id;?>"  enctype="multipart/form-data">
                                    <div class="form-group">
                                        Title:
                                        <input type="text" class="form-control" 
                                               name="expense_title" placeholder="Expense Name"
                                               required="true">
                                    </div>
                                    <div class="form-group">
                                        Date:
                                        <input type="date" class="form-control" min="<?php 
                                        echo $from;?>" max="<?php echo $to?>"  
                                        name="date" required="true">
                                    </div>                                
                                    <div class="form-group">
                                        Amount Spent:
                                        <input type="number" class="form-control" 
                                               name="amount" min="0" placeholder="Amount Spent" 
                                               required="true">
                                    </div>
                                    <div class="form-group">
                                        By:
                                        <select name="person" class="form-control" required="true">
                                            <?php while ($row_member = mysqli_fetch_array($view_member_result)){?>
                                            <option value="<?php echo $member_id = $row_member['member_id'];?>">
                                                <?php echo $row_member['member_name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        Upload Bill:
                                        <input type="file" class="form-control" name="uploadedimage">
                                    </div>
                                    <div class="form-group">
                                        <button class="btn form-control button">Add</button>
                                    </div>                                                                                                            
                                </form>
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-heading" 
                                 style="background-color:#398a7b;color: #f9f9fd;">
                                <div class="row"><center>
                                        <h4>Add New Savings</h4></center>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form method="POST" action="addsavings.php?plan_id=<?php 
                                echo $plan_id;?>" >
                                    <div class="form-group">
                                        Title:
                                        <input type="text" class="form-control" 
                                               name="savings_title" placeholder="Savings Name"
                                               required="true">
                                    </div>
                                    <div class="form-group">
                                        Date:
                                        <input type="date" class="form-control" min="<?php 
                                        echo $from;?>" max="<?php echo $to?>"  
                                        name="date" required="true">
                                    </div>              
                                    <div class="form-group">
                                        Amount Saved:
                                        <input type="number" class="form-control" 
                                               name="amount" min="0" placeholder="Savings amount" 
                                               required="true">
                                    </div>
                                    <div class="form-group">
                                        By:
                                        <select name="person" class="form-control" required="true">
                                            <?php while ($row_member_savings = mysqli_fetch_array($view_member_savings_result)){?>
                                            <option value="<?php echo $member_id = $row_member_savings['member_id'];?>">
                                                <?php echo $row_member_savings['member_name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn form-control button">Add</button>
                                    </div>                 
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'includes/footer.php';?>
    </body>
</html>