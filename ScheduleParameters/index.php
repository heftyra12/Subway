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
                
                    <img src="/Images/temp_top_logo_3.png" align="center">
                </div>
         
           <ul class="subway_tabs">
            <li><a href="/MainMenu/index.php">Home:</a></li>
            <li><a href="/ManageSchedule/index.php">Create Schedule:</a></li>
            <li><a href="/ViewSchedule/index.php">View Schedule:</a></li>
            <li><a href="/ManageEmployee/index.php">Employees:</a</li>
            <li><a href="/EditRequests/index.php">Requests:</a></li>
            <li class="current_position">Business Rules:</li>
        </ul>      
         
         <div id="tab_bar">
            
         </div>
    
        <div id="welcome_body">
        </div>
    </div>    
    </body>
</html>
