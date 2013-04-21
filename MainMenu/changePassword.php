<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <title>Change Password</title>
    </head>
    <body>
        
        <div id="page_top">
            
            <div id="log_out">
            User: <?php echo $_SESSION['user_name'];
                        echo " | <a href=../index.php>Logout</a>";
                     ?>
            </div>
            
            <div id="top_image">
                <img src="/Images/temp_top_logo_3.png" id="image" align="center">
            </div>

            <ul class="subway_tabs">
                <li class="current_position">Home</li>
                <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule</a></li>
                <li><a href="/ManageEmployee/index.php">Employees</a></li>
                <li><a href="/EditRequests/index.php" >Requests</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules</a></li>
            </ul>       

            <div id="tab_bar"></div>

            <div id="normal_body">
                <div id="normal_left">
                    <div id="left_buttons">
                    <form action="/MainMenu/index.php" method="POST">
                        <input type="submit" value ="Home"> 
                    </form>
                    
                    </br>
                    </br>
                    
                    <form action="/index.php" method="POST">
                        <input type="hidden" name="exit" id="exit" value="destroy">
                        <input type="submit" value="Exit">
                    </form>
                    </div>
                </div>

                <div id="normal_right">
                    
                    <?php 
                    
                        if(isset($_SESSION['current_error'])){
                            
                            if($_SESSION['current_error']==="yes"){
                                
                                echo "<script language = javascript> alert('Error: Invalid Current Password:');</script>";
                                unset($_SESSION['current_error']);
                            }
                        }
                        
                        if(isset($_SESSION['new_password_error'])){
                            
                            if($_SESSION['new_password_error']==="yes"){
                                
                                echo "<script language = javascript> alert('New Passwords Do Not Match:');</script>";
                                unset($_SESSION['new_password_error']);
                            }
                        }
                    ?>
                    <div id="password_table">
                        <table>
                            <th id="table_title">Change <?php echo $_SESSION['user_name']; ?>'s Password:</th>
                            <form action="/HelperFiles/validatePassword.php" method ="POST">
                            <tr><td>Enter Current Password: <input type="password" name="current_password" id="current_password"/></td></tr>
                            <tr><td>Enter New Password: <input type="password" name="new_password" id="new_password"/></td></tr>
                            <tr><td> New Password Again: <input type="password" name="new_password_again" id="new_password_again"/></td></tr>
                            <tr><td><input type="submit" value="Change Password"/></td></tr>
                            </form>
                        </table>
                    </div>
                </div>
        </div>
    </body>
</html>
