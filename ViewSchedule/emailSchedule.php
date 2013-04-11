<?php
include_once '../../Subway/HelperFiles/employeeClass.php';
session_start();

include_once '../../Subway/HelperFiles/unsetEmpFields.php';


if(isset($_SESSION['no_product']))
    unset($_SESSION['no_product']);
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
            <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
            <li class="current_position">View Schedule:</li>
            <li><a href="/ManageEmployee/index.php">Employees:</li>
            <li><a href="/EditRequests/index.php">Requests:</a></li>
            <li><a href="/ScheduleParameters/index.php">Business Rules:</a></li>
        </ul>    

        <div id="tab_bar">
            
         </div>
    
    <div id="normal_body">
        
        <div id="normal_left">
            
            <form action="" method="POST">
                <input type="submit" value="Print Schedule" class="subway_buttons"/>
            </form>
            <form action="" method="POST">
                <input type="submit" value="View Other Schedules" class="subway_buttons"/>
            </form>
            
        </div>
        
        <div id="normal_right">
            
            <div id="schedule">
            </div>
            
            <div id="employee_table">
                
                <table>
                    <form action="/HelperFiles/verifyEmail.php" method="POST">
                    <tr><th id="table_title" colspan="3">Employees</th></tr>
                    
                <?php
                
                if(isset($_SESSION['employee_array'])){
                
                    for($x=0;$x<count($_SESSION['employee_array']);$x++){
                     
                        $id = $_SESSION['employee_array'][$x]->getEmployeeID();
                        
                        echo "<tr><td>";
                        echo "<input type='checkbox' name='email_employees[]' value=\'$id\'>";
                        echo "</td><td>";
                        echo $_SESSION['employee_array'][$x]->getEmployeeFirstName();
                        echo "</td><td>";
                        echo $_SESSION['employee_array'][$x]->getEmployeeLastName();
                        echo "</td></tr>";
                    }
                }
                ?>
                    <tr><td colspan="3"><input type="submit" value="Email Schedule"></td><tr>
                    </form> 
                </table>
            </div>
        </div>
    </div>
 <div>
</body>
</html>
