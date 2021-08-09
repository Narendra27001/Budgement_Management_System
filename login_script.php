<?php
require 'includes/common.php';
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = md5(mysqli_real_escape_string($con,$_POST['password']));
$regex_email = "/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/";
//Php validation of email
if(!preg_match($regex_email, $email)){
    echo "<script>alert('Invalid email id!')</script>";
    echo "<script>location.href='login.php'</script>";    
}
//php validation of password
else if (strlen($password) < 6) {
  echo "<script>alert('Password should have at-least 6 characters')</script>";
  echo "<script>location.href='login.php'</script>";  
}
else{
    //To extract and check whether the given email id has been registered or not
    $select_query_user = "CALL `get_user`('$email');";
    $select_query_user_result = mysqli_query($con, $select_query_user);
    if(!mysqli_num_rows($select_query_user_result)){
        echo "<script>alert('Email id is not registered !')</script>";
        echo "<script>location.href='login.php'</script>";            
    }
    else{    
        //To extract the user of given email id
        $user = mysqli_fetch_array($select_query_user_result);
        if($password!=$user['password']){
            echo "<script>alert('Incorrect password !')</script>";
            echo "<script>location.href='login.php'</script>";            
        }
        else{
            //Update session values to keep the user logged in
            $_SESSION['email'] = $user['email'];
            $_SESSION['id'] = $user['id'];
            header('location:home.php');
        }
    }
}