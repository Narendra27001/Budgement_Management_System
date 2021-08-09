<?php
require 'includes/common.php';
include 'includes/functions.php';
$plan_id = $_GET['plan_id'];
$title = mysqli_real_escape_string($con, $_POST['savings_title']);
$date = mysqli_real_escape_string($con, $_POST['date']);
$amount = mysqli_real_escape_string($con, $_POST['amount']);
$member_id = mysqli_real_escape_string($con, $_POST['person']);
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
            echo "<script>alert('savings added successfully')</script>";
            echo "<script>location.href='savingsdistribution.php?plan_id=$plan_id'</script>";           
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