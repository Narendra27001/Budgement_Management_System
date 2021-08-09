<?php
require 'includes/common.php';
$title = mysqli_real_escape_string($con, $_POST['title']);
$from = mysqli_real_escape_string($con, $_POST['from']);
$to = mysqli_real_escape_string($con, $_POST['to']);
$initial_budget = mysqli_real_escape_string($con, $_POST['initial_budget']);
$people_number = mysqli_real_escape_string($con, $_POST['people_number']);
//To add a new plan
$insert_plan = "insert into plans (title,initial_budget,people_number,from_date,to_date,remaining)"
        . " values ('$title','$initial_budget','$people_number','$from','$to','$initial_budget')";
$insert_plan_result = mysqli_query($con, $insert_plan);
if($insert_plan_result){
    $plan_id = mysqli_insert_id($con);
    $user_id = $_SESSION['id'];
    //To map user with his plans
    $insert_users_plans = "insert into users_plans (user_id,plan_id) values ('$user_id','$plan_id')";
    $insert_users_plans_result = mysqli_query($con, $insert_users_plans);
    if($insert_users_plans_result){
        for($i=1;$i<=$people_number;$i++){
            $member_name = mysqli_real_escape_string($con, $_POST["person_name_$i"]);
            //To add participating members of the plan
            $insert_member = "insert into members (member_name,spent,saved) values ('$member_name','0','0')";
            $insert_member_result = mysqli_query($con, $insert_member);
            if($insert_member_result){
                $member_id = mysqli_insert_id($con);
                //To map plan with members
                $insert_plans_members = "insert into plans_members (plan_id,member_id) values ('$plan_id','$member_id')";
                $insert_plans_members_result = mysqli_query($con, $insert_plans_members);
                $flag = 1;
                if($insert_plans_members_result){
                        $success = 1;
                }
                else{
                    $success = 0;
                }
            }
            else{
                $flag = 0;
            }
        }
        if($success && $flag){
            echo "<script>alert('Plan created successfully')</script>";
            echo "<script>location.href='home.php'</script>";            
        }
        else if($flag){
            echo "<script>alert('Some error occurred while mapping plan and member')</script>";
            echo "<script>location.href='newplan.php'</script>";                
        }
        else{
            echo "<script>alert('Some error occurred while inserting member')</script>";
            echo "<script>location.href='newplan.php'</script>";                            
        }
    }
    else{
        echo "<script>alert('Some error occurred while mapping user and plan ')</script>";
        echo "<script>location.href='newplan.php'</script>";    
    }
}
 else {
    echo "<script>alert('Some error occurred while creating a plan ')</script>";
    echo "<script>location.href='newplan.php'</script>";
}