<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>

        <title></title>
    </head>
    <body>

        <div id="page_top"/>
        
            <div id="top_image">

                <img src="/Images/temp_top_logo.png" align="center">
            </div>

        <ul class="subway_tabs">
            <li><a href="/MainMenu/index.php">Welcome:</a></li>
            <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
            <li class="current_position">View Schedule:</li>
            <li><a href="/ManageEmployee/index.php">Employees:</li>
            <li><a href="/EditRequests/index.php">Requests:</a></li>
            <li><a href="/ScheduleParameters/index.php">Business Rules:</a></li>
        </ul>    

        <div id="tab_bar">
            
         </div>
    
    <div id="view_schedule_body">
        
        <div id="view_schedule_left">
            
            <form action="" method="POST">
                <input type="submit" value="Print Schedule" class="subway_buttons"/>
            </form>
            <form action="" method="POST">
                <input type="submit" value="Email Schedule" class="subway_buttons"/>
            </form>
            <form action="" method="POST">
                <input type="submit" value="View Other Schedules" class="subway_buttons"/>
            </form>
            
        </div>
        
        <div id="view_schedule_right">
            
            
        </div>
        
    </div>
 <div>
</body>
</html>
