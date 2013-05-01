<?php
session_start();
include_once'../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/employeeClass.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';
include_once'../../Subway/HelperFiles/productivityClass.php';

/*BEGIN Check for productivity for current week*/
$prodSQLCommand = 'SELECT store_id, week_no, units FROM subway.productivity';
$result = mysqli_query($db_connect,$prodSQLCommand);

$prod_array = array();
$day_array = array();
date_default_timezone_set('America/Chicago');
$_SESSION['current_week'] = date("W");
$_SESSION['current_prod'] = false;
$day = 0;
$new_prod = new productivityClass;
while($row = mysqli_fetch_array($result)){
                
    $new_prod->setStoreNumber($row['store_id']);
    $new_prod->setWeekNumber($row['week_no']);
    array_push($day_array,$row['units']);
         
    if($new_prod->getWeekNumber() == $_SESSION['current_week'])
        $_SESSION['current_prod'] = true;
    
    if($day ==6){
        $new_prod->setAllProd($day_array);
        array_push($prod_array,$new_prod);
        $new_prod = new productivityClass;
        $day =0;    
    }
    else{
        $day++;
    }
}
/*END Productivity Check*/

$sqlCommand = 'SELECT employee_id,
                      first_name,
                      last_name,
                      emp_type,
                      emp_minor,
                      monday_start,
                      monday_end,
                      tuesday_start,
                      tuesday_end,
                      wednesday_start,
                      wednesday_end,
                      thursday_start,
                      thursday_end,
                      friday_start,
                      friday_end,
                      saturday_start,
                      saturday_end,
                      sunday_start,
                      sunday_end
                      FROM subway.employee';

$result = mysqli_query($db_connect, $sqlCommand);

$employee_array = array();

while ($row = mysqli_fetch_array($result)) {

    $employee = new employeeClass;
    
    $employee->setEmployeeID($row["employee_id"]);
    $employee->setEmployeeFirstName($row["first_name"]);
    $employee->setEmployeeLastName($row["last_name"]);
    $employee->setEmployeeType($row["emp_type"]);
    $employee->setEmployeeMinor($row["emp_minor"]);
    $employee->setMondayStart($row["monday_start"]);
    $employee->setMondayEnd($row["monday_end"]);
    $employee->setTuesdayStart($row["tuesday_start"]);
    $employee->setTuesdayEnd($row["tuesday_end"]);
    $employee->setWednesdayStart($row["wednesday_start"]);
    $employee->setWednesdayEnd($row["wednesday_end"]);
    $employee->setThursdayStart($row["thursday_start"]);
    $employee->setThursdayEnd($row["thursday_end"]);
    $employee->setFridayStart($row["friday_start"]);
    $employee->setFridayEnd($row["friday_end"]);
    $employee->setSaturdayStart($row["saturday_start"]);
    $employee->setSaturdayEnd($row["saturday_end"]);
    $employee->setSundayStart($row["sunday_start"]);
    $employee->setSundayEnd($row["sunday_end"]);

    array_push($employee_array, $employee);
}
$_SESSION['employee_array'] = $employee_array;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <title>Home</title>
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
                <li><a href='/ManageSchedule/index.php'>Create Schedule</a></li>
                <li><a href="/ManageEmployee/index.php">Employees</a></li>
                <li><a href="/EditRequests/index.php" >Requests</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules</a></li>
            </ul>       

            <div id="tab_bar"></div>

            <div id="normal_body">
                <div id="normal_left">
                    <div id="left_buttons">
                    <form action="changePassword.php" >
                        <input type="submit" value ="Change Password"> 
                    </form>
                    </div>
                </div>

                <div id="normal_right">

                    <?php
                    
                        if(isset($_SESSION['password_change_success']))
                            
                            if($_SESSION['password_change_success']==="yes"){
                                
                                //Tell user password change was successful
                                echo "<script language = javascript>alert('Password Change Successful');</script>";
                                unset($_SESSION['password_change_success']);
                                
                                //If either of the password change error fiedls are set, unset them. 
                                if(isset($_SESSION['current_password_error']))
                                    unset($_SESSION['current_password_error']);
                                if(isset($_SESSION['new_password_error']))
                                    unset($_SESSION['new_password_error']);
                            }
                    ?>
                    <div id="home_sched">
                        <table>
                            <tr><th id="table_title" colspan="15">This Week's Schedule</th></tr>
                            <tr><th>Employee:</th><th>Wednesday:</th><th>Thursday:</th><th>Friday:</th><th>Saturday:</th>
                                <th>Sunday:</th><th>Monday:</th><th>Tuesday:</th><th>Total Hours:</th></tr> 

                            <?php
                            for ($x = 0; $x < count($_SESSION['employee_array']); $x++) {

                                echo "<tr><td class='sched_emp'>";
                                echo $_SESSION['employee_array'][$x]->getEmployeeFirstName() . " ";
                                echo $_SESSION['employee_array'][$x]->getEmployeeLastName() . " </td>";
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
        </div>
    </body>
</html>
