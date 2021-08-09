<?php
require 'includes/common.php';
include 'includes/functions.php';
$plan_id = $_GET['plan_id'];
$title = mysqli_real_escape_string($con, $_POST['expense_title']);
$date = mysqli_real_escape_string($con, $_POST['date']);
$amount = mysqli_real_escape_string($con, $_POST['amount']);
$member_id = mysqli_real_escape_string($con, $_POST['person']);
$spent = 0;
//To save the bill if uploaded
if (! empty ($_FILES[ "uploadedimage" ][ "name" ])) {
    $file_name=$_FILES[ "uploadedimage" ][ "name" ];
    $temp_name=$_FILES[ "uploadedimage" ][ "tmp_name" ];
    $imgtype=$_FILES[ "uploadedimage" ][ "type" ];
    $ext= GetImageExtension($imgtype);
    $imagename=date( "d-m-Y" ). "-" .time().$ext;
    $target_path = "img/" .$imagename;
    if (move_uploaded_file($temp_name, $target_path)){
        $image = $target_path;
    }
    else{
        echo "<script>alert('Some error occurred while uploading image')</script>";
        echo "<script>location.href='home.php'</script>";       
    }
}
else{
    $image = "blank";
}
//to save the expense details
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
            echo "<script>alert('expense added successfully')</script>";
            echo "<script>location.href='expensedistribution.php?plan_id=$plan_id'</script>";           
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