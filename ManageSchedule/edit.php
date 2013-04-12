<?php

session_start();
echo"HI";

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

        <title></title>
    </head>
    <body>

        <div id="page_top"/>
            <div id="top_image">

                <img src="/Images/temp_top_logo.png" id="image" align="center">
            </div>
        
            <ul class="subway_tabs">
                <li><a href="/MainMenu/index.php">Welcome</a></li>
                <li class="current_position">Create Schedule</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule</a></li>
                <li><a href="/ManageEmployee/index.php">Employees</a></li>
                <li><a href="/EditRequests/index.php">Requests</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules</a></li>
            </ul>     
        
            <div id="tab_bar">
            
            </div>

    <div id="normal_body">

        <div id="normal_left">
            <form  action="productivity.php" method="POST">
                <input type="submit" value="Enter Productivity" class="subway_buttons"/>
            </form>
            <form action="index.php" method="POST">
                <input type="submit" value="Generate Schedule" class="subway_buttons"/>
            </form>
            <form action="edit.php" method="POST">
                <input type="submit" value="Edit Schedule" class="subway_buttons"/>
            </form>
        </div>

        <div id="normal_right">
                
                <table>
                <form action="" method="POST">
                    <tr><th id="table_title" colspan="15">Edit Schedule:</th></tr>
                <tr><th>Employee:</th><th>Wednesday:</th><th>Thursday:</th><th>Friday:</th><th>Saturday:</th>
                    <th>Sunday:</th><th>Monday:</th><th>Tuesday:</th><th>Total Hours:</th></tr> 
                 
                <?php
                
                    for($x=0;$x<count($_SESSION['schedule_array']);$x++){
                        
                        echo "<tr><td class='sched_emp'>";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeFirstName()." ";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeLastName()." </td>";
                        echo "<td><input type='text' id='tuesday_sched' name='wednesday_sched' class='sched_field'></td>";
                        echo "<td><input type='text' id='thursday_sched' name='thursday_sched' class='sched_field'></td>";    
                        echo "<td><input type='text' id='friday_sched' name='friday_sched' class='sched_field'></td>";
                        echo "<td><input type='text' id='saturday_sched' name='saturday_sched' class='sched_field'></td>";
                        echo "<td><input type='text' id='sunday_sched' name='sunday_sched' class='sched_field'></td>";
                        echo "<td><input type='text' id='monday_sched' name='monday_sched' class='sched_field'></td>";
                        echo "<td><input type='text' id='tuesday_sched' name='tuesday_sched' class='sched_field'></td>";
                        echo "<td><input type='text' id='total_hours' name='total_hours' class='sched_field'></td>";
                        echo "</tr>";
                    }
                ?>
                <tr><td colspan="9"><input type="submit" value="Edit Schedule:"/></td></tr>  
                </form>
                </table>
            </div>     
        </div>
    </div>
    </div>
</body>
</html>
