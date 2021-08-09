<?php
require 'includes/common.php';
$type=$_GET['type'];
$id=$_GET['id'];
if($type=='expenses'){
    $select_member="select pm.plan_id,pm.member_id from members_expenses me,"
            . "plans_members pm where pm.member_id=me.member_id  and me.expense_id=$id";
    $select_member_result= mysqli_query($con, $select_member);
    if($select_member_result){
        $id_result= mysqli_fetch_array($select_member_result);
        $mid=$id_result['member_id'];
        $pid=$id_result['plan_id'];
        $delete_expense="delete from expenses where  expenses.id=$id";
        $delete_expense_result= mysqli_query($con, $delete_expense);
        if($delete_expense_result){
            $spent_query="select sum(expense_amount)"
                . " from expenses e,members_expenses me where e.id="
                . "me.expense_id and me.member_id=$mid";
            $spent_query_result= mysqli_query($con, $spent_query);
            $spent_array= mysqli_fetch_array($spent_query_result);
            $spent=$spent_array['sum(expense_amount)'];
            if($spent==NULL){
                $spent=0;
            }
            $update_members="update members set spent=$spent where members.id=$mid";
            $update_members_result= mysqli_query($con, $update_members);
            if($update_members_result){
                echo "<script>alert('Expense deleted successfully!')</script>";
                echo "<script>location.href='expensedistribution.php?plan_id=$pid'</script>";                               
            }
        }
    }
}
else if($type=='savings'){
    $select_member="select pm.plan_id,pm.member_id from members_savings ms,"
            . "plans_members pm where pm.member_id=ms.member_id  and ms.savings_id=$id";
    $select_member_result= mysqli_query($con, $select_member);
    if($select_member_result){
        $id_result= mysqli_fetch_array($select_member_result);
        $mid=$id_result['member_id'];
        $pid=$id_result['plan_id'];
        $delete_savings="delete from savings where  savings.id=$id";
        $delete_savings_result= mysqli_query($con, $delete_savings);
        if($delete_savings_result){
            $saved_query="select sum(savings_amount)"
                . " from savings s,members_savings ms where s.id="
                . "ms.savings_id and ms.member_id=$mid";
            $saved_query_result= mysqli_query($con, $saved_query);
            $saved_array= mysqli_fetch_array($saved_query_result);
            $saved=$saved_array['sum(savings_amount)'];
            if($saved==NULL){
                $saved=0;
            }
            $update_members="update members set saved=$saved where members.id=$mid";
            $update_members_result= mysqli_query($con, $update_members);
            if($update_members_result){
                echo "<script>alert('Savings deleted successfully!')</script>";
                echo "<script>location.href='savingsdistribution.php?plan_id=$pid'</script>";                               
            }
        }
    }
}