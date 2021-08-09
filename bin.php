<?php 
require 'includes/common.php';
    if (!isset($_SESSION['email'])) { 
    header('location: home.php');
    }
    $plan_id=$_GET['plan_id'];
    $select_user="select * from users_plans up where up.plan_id=$plan_id";
    $select_user_result= mysqli_query($con, $select_user);
    $row_user= mysqli_fetch_array($select_user_result);
    if($_SESSION['id']!=$row_user['user_id']){
        header('location:home.php');
    }    
    $_SESSION['plan_id']=$plan_id;    
    $select_history="CALL `get_history`('$plan_id')";
    $select_history_result= mysqli_query($con, $select_history);
    $num= mysqli_num_rows($select_history_result);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Bin</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <script type="text/javascript" src="bootstrap/js/jquery-3.5.1.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <link href="style.css" rel="stylesheet" type="text/css">
        <style>
        #binTable{
            padding-top: 100px;
            padding-bottom: 50px;
        }
            
        </style>
    </head>
    <body id="webpage_color">
        <?php include 'includes/header.php';
        include 'includes/functions.php';
        unset($_SESSION['plan_id']);?>
        <div class="container" id='binTable'>
            <div class="table-responsive table-striped">
            <table class="table">
                    <tbody>
                        <tr style="color:#398a7b;">
                            <th>Member Name</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                        <?php if($num>0){ 
                        while($row_bin= mysqli_fetch_array($select_history_result)){?>
                        <tr>
                            <td class="text-warning"><?php  echo $row_bin['member_name'] ?></td>
                            <td><?php  echo $row_bin['title'] ?></td>
                            <td><?php  echo $row_bin['type'] ?></td>
                            <td><?php  $date=$row_bin['date'];
                            echo day($date)." ".month($date).year($date);?></td>
                            <td><?php  echo $row_bin['amount'] ?></td>
                            <td><a href="restore.php?id=<?php echo $row_bin['id'];?>" class='remove_item_link'> Restore</a></td>
                        </tr>
                        <?php } 
                        }
                        else{
                            echo "<script>alert('Bin is empty')</script>";
                            echo "<script>location.href='home.php'</script>";
                        }?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php include 'includes/footer.php';?>
    </body>
</html>