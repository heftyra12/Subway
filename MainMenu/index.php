<?php
session_start();

include_once'../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/employeeClass.php';


$sqlCommand = "SELECT employee_id, first_name, last_name from subway.employee";

$result = mysqli_query($db_connect, $sqlCommand);

$schedule_array = array();

$x = 0;

while ($row = mysqli_fetch_array($result)) {

    $employee = new employeeClass;

    $employee->setEmployeeID($row["employee_id"]);
    $employee->setEmployeeFirstName($row["first_name"]);
    $employee->setEmployeeLastName($row["last_name"]);
    array_push($schedule_array, $employee);
}

$_SESSION['schedule_array']=$schedule_array;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <title>Subway Scheduling Program: Main Menu</title>
    </head>
    <body>

            <div id="page_top">
                <div id="top_image">
                
                    <img src="/Images/temp_top_logo.png" align="center">
                </div>
            
            <ul class="subway_tabs">
                <li class="current_position">Welcome:</li>
                <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule:</a></li>
                <li><a href="/ManageEmployee/index.php">Employees:</a></li>
                <li><a href="/EditRequests/index.php" >Requests:</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules:</a></li>
            </ul>       
            
            <div id="tab_bar">
            
            </div>

        <div id="welcome_body">
        
        
            <div id="welcome_left">
                
                <form action="/HelperFiles/changePassword.php" method="POST">
                    
                    <input type="submit" value ="Change Password"> 
                </form>
                 </br>
                    </br>
                <form action="<?php session_destroy();?>/index.php" method="POST">
                    <input type="submit" value="Exit">
                </form>
                
            </div>
            
            <div id="welcome_right">
                
                <div id="welcome_title">This Week's Schedule</div>
                <div id="welcome_sched">
                    <table>
                    <tr><th>Employee:</th><th>Wednesday:</th><th>Thursday:</th><th>Friday:</th><th>Saturday:</th>
                    <th>Sunday:</th><th>Monday:</th><th>Tuesday:</th><th>Total Hours:</th></tr> 
                
                    </br>   
                  
                <?php
                
                    for($x=0;$x<count($_SESSION['schedule_array']);$x++){
                        
                        echo "<tr><td class='sched_emp'>";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeFirstName()." ";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeLastName()." </td>";
                        echo "<td><p class='generate_text_field'></p></td>";
                        echo "<td><p class='generate_text_field'></p></td>";    
                        echo "<td><p class='generate_text_field'></p></td>";
                        echo "<td><p class='generate_text_field'></p></td>";
                        echo "<td><p class='generate_text_field'></p></td>";
                        echo "<td><p class='generate_text_field'></p></td>";
                        echo "<td><p class='generate_text_field'></p></td>";
                        echo "<td><p class='generate_text_field'></p></td>";
                        echo "</tr>";
                    }
                ?>
                </table>
                </div>    
                    
                
                
            </div>
            
            
        </div>
        </div>
        
    </body>
</html>


