        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="index.php" class="navbar-brand">Ct&#8377l Budget</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="aboutus.php"><span class="glyphicon glyphicon-info-sign"></span> About Us</a></li>
                        <?php 
                          if(!isset($_SESSION['email'])){?>
                        <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <?php
                          }else{
                              if(isset($_SESSION['plan_id'])){?>?>
                        <li><a href="bin.php?plan_id=<?php echo $_SESSION['plan_id'];?>"><span class="glyphicon glyphicon-trash"></span> Bin</a>
                              <?php }?>
                        <li><a href="changepassword.php"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
                        <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                          <?php
                          }?>
                    </ul>
                </div>
            </div>
        </nav>
