<?php 
require 'includes/common.php';
$old_password = md5(mysqli_real_escape_string($con,$_POST['old_password']));
$new_password = mysqli_real_escape_string($con,$_POST['new_password']);
$retype_password = md5(mysqli_real_escape_string($con,$_POST['retype_password']));
$user =  $_SESSION['id'];
//To extract old password of the user
$old = "select password from users where id = $user";
$old_result = mysqli_query($con, $old);
$old_password_result = mysqli_fetch_array($old_result);
$old_password_db = $old_password_result['password'];
if( $old_password_db==$old_password){
    if(md5($new_password) == $retype_password){
        if(strlen($new_password)>6){
            $coded_new_password = md5($new_password);
            //To update new password of the user after satisfying all the constraints of changing a password
            $update_password = "update users set password = '$coded_new_password' where users.id = $user";
            $update_password_result = mysqli_query($con,$update_password);
            if($update_password_result){
                echo "<script>alert('Password updated and logged out succesfully. Login again')</script>";
                echo "<script>location.href='logout.php'</script>";
            }
            else{
                echo "<script>alert('Some error occurred while updating password')</script>";
                echo "<script>location.href='changepassword.php'</script>";
            }
        }
        else{
            echo "<script>alert('Password should have at-least 6 characters')</script>";
            echo "<script>location.href='changepassword.php'</script>";
        }
    }
    else{
        echo "<script>alert('New password does not match with retyped password')</script>";
        echo "<script>location.href='changepassword.php'</script>";
    }
}
else{
    echo "<script>alert('Old password does not match')</script>";
    echo "<script>location.href='changepassword.php'</script>";
}