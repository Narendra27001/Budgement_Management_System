<?php
require 'includes/common.php';
$id=$_GET['id'];
$select_query="select * from delete_history dh,plans_members pm where dh.member_id=pm.member_id and dh.id=$id";
$select_query_result= mysqli_query($con, $select_query);
$row= mysqli_fetch_array($select_query_result);
if($row['type']=='expenses'){
    $plan_id = $row['plan_id'];
    $title = $row['title']; 
    $date = $row['date'];
    $amount = $row['amount'];
    $member_id = $row['member_id'];
    $image = $row['image'];
    $spent = 0;
    $insert_expense = "insert into expenses (expense_title,expense_date,expense_amount,expense_image) "
        . "values ('$title','$date','$amount','$image');";
    $insert_expense_result = mysqli_query($con, $insert_expense);
    if($insert_expense_result){
        $expense_id = mysqli_insert_id($con);
        $insert_expense_member = "insert into members_expenses (member_id,expense_id) values ('$member_id','$expense_id')";
        $insert_expense_member_result = mysqli_query($con, $insert_expense_member);
        if($insert_expense_member_result){
            //to extract all the expenses spent by a member in a plan
            $view_spent = "select expense_amount from members_expenses me inner join members m"
                    . " on me.member_id = m.id inner join expenses e on me.expense_id= e.id "
                    . "where me.member_id = $member_id";
            $view_spent_result = mysqli_query($con, $view_spent);
            while($row = mysqli_fetch_array($view_spent_result)){
                 $spent+=$row['expense_amount'];
            }
            //to update the amount spent by the member including the new expense
            $update_spent = "update members set spent = '$spent' where members.id = $member_id";
            $update_spent_result = mysqli_query($con, $update_spent);
            if($update_spent_result){
                $delete_history="delete from delete_history where id=$id";
                $delete_history_result= mysqli_query($con, $delete_history);
                if($delete_history_result){
                echo "<script>alert('expense added successfully')</script>";
                echo "<script>location.href='expensedistribution.php?plan_id=$plan_id'</script>";
                }
            }
            else{
                echo "<script>alert('some error occurred while updating expense')</script>";
                echo "<script>location.href='home.php'</script>";           
            }
        }
        else{
                echo "<script>alert('some error occurred while updating expense')</script>";
                echo "<script>location.href='home.php'</script>";           
        }
    }
}
else if($row['type']=='savings'){
    $plan_id = $row['plan_id'];
    $title = $row['title']; 
    $date = $row['date'];
    $amount = $row['amount'];
    $member_id = $row['member_id'];
    $saved = 0;
    //to save the savings details
    $insert_savings = "insert into savings (savings_title,savings_date,savings_amount) "
            . "values ('$title','$date','$amount');";
    $insert_savings_result = mysqli_query($con, $insert_savings);
    if($insert_savings_result){
        $savings_id = mysqli_insert_id($con);
        $insert_savings_member = "insert into members_savings (member_id,savings_id) values ('$member_id','$savings_id')";
        $insert_savings_member_result = mysqli_query($con, $insert_savings_member);
        if($insert_savings_member_result){
            //to extract all the savings saved by a member in a plan
            $view_saved = "select savings_amount from members_savings ms inner join members m"
                    . " on ms.member_id = m.id inner join savings s on ms.savings_id= s.id "
                    . "where ms.member_id = $member_id";
            $view_saved_result = mysqli_query($con, $view_saved);
            while($row = mysqli_fetch_array($view_saved_result)){
                 $saved+=$row['savings_amount'];
            }
    //        to update the amount saved by the member including the new savings
            $update_saved = "update members set saved = '$saved' where members.id = $member_id";
            $update_saved_result = mysqli_query($con, $update_saved);
            if($update_saved_result){
                $delete_history="delete from delete_history where id=$id";
                $delete_history_result= mysqli_query($con, $delete_history);
                if($delete_history_result){
                echo "<script>alert('savings added successfully')</script>";
                echo "<script>location.href='savingsdistribution.php?plan_id=$plan_id'</script>";           
                }
            }
            else{
                echo "<script>alert('some error occurred while updating savings')</script>";
                echo "<script>location.href='home.php'</script>";           
            }
        }
        else{
                echo "<script>alert('some error occurred while updating savings')</script>";
                echo "<script>location.href='home.php'</script>";           
        }
    }    
}