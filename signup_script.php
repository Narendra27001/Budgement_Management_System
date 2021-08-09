<?php
require 'includes/common.php';
$name = mysqli_real_escape_string($con,$_POST['name']);
$email = mysqli_real_escape_string($con,$_POST['email']);
$password = md5(mysqli_real_escape_string($con,$_POST['password']));
$contact = mysqli_real_escape_string($con,$_POST['phone_number']);
$regex_name = "/^[a-zA-Z-' ]*$/";
$regex_email = "/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/";
$regex_contact = "/[789][0-9]{9}/";
//Php validation of name
if(!preg_match($regex_name,$name)){
    echo "<script>alert('Enter a proper name !')</script>";
    echo "<script>location.href='signup.php'</script>";
}
//Php validation of email
else if(!preg_match($regex_email, $email)){
    echo "<script>alert('Invalid email id!')</script>";
    echo "<script>location.href='signup.php'</script>";    
}
//Php validation of password
else if (strlen($password) < 6) {
  echo "<script>alert('Password should have at-least 6 characters')</script>";
  echo "<script>location.href='signup.php'</script>";  
}
//Php validation of contact number
else if(!preg_match($regex_contact, $contact)){
    echo "<script>alert('Invalid phone number !')</script>";
    echo "<script>location.href='signup.php'</script>";    
}
else{
    //To check whether given email id is already registered or not
    $select_query = "select * from users WHERE email=$email;";
    $select_query_result = mysqli_query($con, $select_query);
    if(mysqli_num_rows($select_query_result)){
        echo "<script>alert('Email is already registered')</script>";
        echo "<script>location.href='signup.php'</script>";
    }
    else{
        //To add new user
        $insert_query = "insert into users(name,email,password,phone) values ('$name','$email','$password','$contact')";
        $insert_query_result = mysqli_query($con,$insert_query);
        if($insert_query_result){
            $_SESSION['id'] = mysqli_insert_id($con); 
            $_SESSION['email']=$email;
            if(isset($_SESSION['email'])){
                echo "<script>alert('User successfully registered')</script>";
                header('location:home.php');  
            }
            else{
                header('location:index.php');
            }
        }
        else{
            header('location:index.php');
        }
    }
}