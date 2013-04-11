<?php
session_start();

include_once '../../Subway/HelperFiles/employeeClass.php';
include_once '../../Subway/HelperFiles/Availability.php';
include_once '../../Subway/HelperFiles/config.php';

if(isset($_SESSION['no_product']))
    unset($_SESSION['no_product']);
if(isset($_SESSION['no_day_selected']))
    unset($_SESSION['no_day_selected']);

//Variables to hold textfield data / input errors

if(!isset($_SESSION['first_name']))
    $_SESSION['first_name']= "";
if(!isset($_SESSION['last_name']))
    $_SESSION['last_name']= "";
if(!isset($_SESSION['email']))
    $_SESSION['email']= "";
if(!isset($_SESSION['emp_type']))
    $_SESSION['emp_type']= "";
if(!isset($_SESSION['emp_minor']))
    $_SESSION['emp_minor']= "";

//Checks for updating an employee without selecting from the list
if (!isset($_SESSION['no_employee_selected']))
    $_SESSION['no_employee_selected'] = "false";
//Trying to add an employee when the user is working with a selected employee from the list
if (!isset($_SESSION['duplicate_employee']))
    $_SESSION['duplicate_employee'] = "false";
if(!isset($_SESSION['fulltime_minor']))
    $_SESSION['fulltime_minor'] = "false";
$sqlCommand = 'SELECT employee_id,first_name,last_name,email,emp_type,emp_minor
    FROM subway.employee';

$result = mysqli_query($db_connect, $sqlCommand);

$employee_array = array();

$x = 0;

while ($row = mysqli_fetch_array($result)) {

    $employee = new employeeClass;
    
    $employee->setEmployeeID($row["employee_id"]);
    $employee->setEmployeeFirstName($row["first_name"]);
    $employee->setEmployeeLastName($row["last_name"]);
    $employee->setEmployeeEmail($row["email"]);
    $employee->setEmployeeType($row["emp_type"]);
    $employee->setEmployeeMinor($row["emp_minor"]);

    array_push($employee_array, $employee);
}

$sqlCommand = 'SELECT employee_id,monday_start,monday_end,tuesday_start,tuesday_end,
    wednesday_start,wednesday_end,thursday_start,thursday_end,friday_start,friday_end,
    saturday_start,saturday_end,sunday_start,sunday_end FROM subway.employee';

$new_result = mysqli_query($db_connect, $sqlCommand);

$availability_array = array();

while($row = mysqli_fetch_array($new_result)){
    
    $availability = new Availability;
    
    $availability->setEmployeeID($row["employee_id"]);
    $availability->setMondayStart($row["monday_start"]);
    $availability->setMondayEnd($row["monday_end"]);
    $availability->setTuesdayStart($row["tuesday_start"]);
    $availability->setTuesdayEnd($row["tuesday_end"]);
    $availability->setWednesdayStart($row["wednesday_start"]);
    $availability->setWednesdayEnd($row["wednesday_end"]);
    $availability->setThursdayStart($row["thursday_start"]);
    $availability->setThursdayEnd($row["thursday_end"]);
    $availability->setFridayStart($row["friday_start"]);
    $availability->setFridayEnd($row["friday_end"]);
    $availability->setSaturdayStart($row["saturday_start"]);
    $availability->setSaturdayEnd($row["saturday_end"]);
    $availability->setSundayStart($row["sunday_start"]);
    $availability->setSundayEnd($row["sunday_end"]);
    
    array_push($availability_array,$availability);
}
// echo "employee: " + count($employee_array) + "<br />";
// echo "availability:  count($availability_array)<br />";
for($x=0;$x< count($availability_array);$x++){
    
    if($availability_array[$x]->getEmployeeID() === $employee_array[$x]->getEmployeeID()){
        
        $employee_array[$x]->setEmployeeAvailability($availability_array[$x]);
    }
}

$_SESSION['availability_array'] = $availability_array;
$_SESSION['employee_array'] = $employee_array;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <title>Subway Scheduling Program: Employees</title>
    </head>
    <body>

        <div id="page_top"/>
        
            <div id="top_image">

                <img src="/Images/temp_top_logo_3.png" id="image" align="center">
            </div>

            <ul class="subway_tabs">
                <li><a href="/MainMenu/index.php">Home:</a></li>
                <li><a href="/ManageSchedule/index.php">Create Schedule:</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule:</a></li>
                <li class="current_position">Employees:</li>
                <li><a href="/EditRequests/index.php" value="edit_requests">Requests:</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules:</a></li>
            </ul>   

            <div id="tab_bar">
            
            </div>
    
    <div id="employee_body">

        <?php
        if ($_SESSION['no_employee_selected'] === "true") {

            echo "<script language=javascript>alert('Please select an employee to modify')</script>";
            unset($_SESSION['no_employee_selected']);
        }

        if ($_SESSION['duplicate_employee'] === "true") {

            echo "<script language=javascript>alert('Error: Cannot add a duplicate employee')</script>";
            unset($_SESSION['duplicate_employee']);
        }
        if($_SESSION['fulltime_minor'] === "true"){
            
            echo "<script language=javascript>alert('Error: A minor cannot be a full-time employee')</script>";
            unset($_SESSION['fulltime_minor']);
        }
        ?>
        
            <div id="employee_left">
            <table id="emp_table">
                <th id="table_title" colspan="4">Edit Employees:</th>
                <form action="/HelperFiles/validateEmployee.php" method="POST">

                    <tr><td colspan="3">First Name:<input type="text" id="first_name" name="first_name" value="<?php echo $_SESSION['first_name'];?>" required/></td></tr>
                    <tr><td colspan="3">Last Name:<input type="text" id="last_name" name="last_name" value="<?php echo $_SESSION['last_name'];?>"required/></td></tr>
                    <tr><td colspan="3">Email:<input type="text" id="email" name="email" value="<?php echo $_SESSION['email']?>" required/></td></tr>
                    
                    <tr><td colspan="3">Type:<select id="emp_type" name="emp_type" value="<?php echo $_SESSION['emp_type']; ?>"/>
                                                <option value="F">Full-Time</option>
                                                <option value="P">Part-Time</option>
                                                <option value="M">Manager</option>
                                            </select></td></tr>
                    <tr><td colspan="3">Minor:<select id="emp_minor" name="emp_minor" value="<?php echo $_SESSION['emp_minor'];?>"/>
                                                 <option value="N">No</option>
                                                 <option value="Y">Yes</option>
                                            </select></td></tr>
                    <tr><td colspan="3">Action:<select id="update_option" name="update_option" value="<?php echo $_SESSION['update_option'];?>"/>
                                                <option value="Add">Add</option>
                                                <option value="Update">Update</option>
                                                <option value="Delete">Delete</option>
                                            </select></td></tr>
                    <tr><td>Availability:</td><td>Start:</td><td>End:</td></tr>
                                    
                    <tr><td>Monday:</td><td>
                           <select id="monday_start" name="monday_start" value="">
                               <option value="600" onclick="startTime('monday_start')">06:00</option>
                               <option value="630" onclick="startTime('monday_start')">06:30</option>
                               <option value="700" onclick="startTime('monday_start')">07:00</option>
                               <option value="730" onclick="startTime('monday_start')">07:30</option>
                               <option value="800" onclick="startTime('monday_start')">08:00</option>
                               <option value="830" onclick="startTime('monday_start')">08:30</option>
                               <option value="900" onclick="startTime('monday_start')">09:00</option>
                               <option value="930" onclick="startTime('monday_start')">09:30</option>
                               <option value="1000"onclick="startTime('monday_start')">10:00</option>
                               <option value="1030" onclick="startTime('monday_start')">10:30</option>
                               <option value="1100"onclick="startTime('monday_start')">11:00</option>
                               <option value="1130" onclick="startTime('monday_start')">11:30</option>
                               <option value="1200" onclick="startTime('monday_start')">12:00</option>
                               <option value="1230" onclick="startTime('monday_start')">12:30</option>
                               <option value="1300" onclick="startTime('monday_start')">1:00</option>
                               <option value="1330" onclick="startTime('monday_start')">1:30</option>
                               <option value="1400" onclick="startTime('monday_start')">2:00</option>
                               <option value="1450" onclick="startTime('monday_start')">2:30</option>
                               <option value="1500" onclick="startTime('monday_start')">03:00</option>
                               <option value="1530" onclick="startTime('monday_start')">03:30</option>
                               <option value="1600" onclick="startTime('monday_start')">04:00</option>
                               <option value="1630" onclick="startTime('monday_start')">04:30</option>
                               <option value="1700" onclick="startTime('monday_start')">05:00</option>
                               <option value="1730" onclick="startTime('monday_start')">05:30</option>
                               <option value="1800" onclick="startTime('monday_start')">06:00</option>
                               <option value="1830" onclick="startTime('monday_start')">06:30</option>
                               <option value="1900" onclick="startTime('monday_start')">07:00</option>
                               <option value="1930" onclick="startTime('monday_start')">07:30</option>
                               <option value="2000" onclick="startTime('monday_start')">08:00</option>
                               <option value="2030" onclick="startTime('monday_start')">08:30</option>
                               <option value="2100" onclick="startTime('monday_start')">09:00</option>
                               <option value="2130" onclick="startTime('monday_start')">09:30</option>
                               <option value="2200" onclick="startTime('monday_start')">10:00</option>
                           </select></td><td>
               <select name="monday_end" id="monday_end" value="">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Tuesday:</td><td><select id="tuesday_start" name="tuesday_start" value="">
                               <option value="600" onclick="startTime('tuesday_start')">06:00</option>
                               <option value="630" onclick="startTime('tuesday_start')">06:30</option>
                               <option value="700" onclick="startTime('tuesday_start')">07:00</option>
                               <option value="730" onclick="startTime('tuesday_start')">07:30</option>
                               <option value="800" onclick="startTime('tuesday_start')">08:00</option>
                               <option value="830" onclick="startTime('tuesday_start')">08:30</option>
                               <option value="900" onclick="startTime('tuesday_start')">09:00</option>
                               <option value="930" onclick="startTime('tuesday_start')">09:30</option>
                               <option value="1000" onclick="startTime('tuesday_start')">10:00</option>
                               <option value="1030" onclick="startTime('tuesday_start')">10:30</option>
                               <option value="1100" onclick="startTime('tuesday_start')">11:00</option>
                               <option value="1130" onclick="startTime('tuesday_start')">11:30</option>
                               <option value="1200" onclick="startTime('tuesday_start')">12:00</option>
                               <option value="1230" onclick="startTime('tuesday_start')">12:30</option>
                               <option value="1300" onclick="startTime('tuesday_start')">01:00</option>
                               <option value="1330" onclick="startTime('tuesday_start')">01:30</option>
                               <option value="1400" onclick="startTime('tuesday_start')">02:00</option>
                               <option value="1450" onclick="startTime('tuesday_start')">02:30</option>
                               <option value="1500" onclick="startTime('tuesday_start')">03:00</option>
                               <option value="1530" onclick="startTime('tuesday_start')">03:30</option>
                               <option value="1600" onclick="startTime('tuesday_start')">04:00</option>
                               <option value="1630" onclick="startTime('tuesday_start')">04:30</option>
                               <option value="1700" onclick="startTime('tuesday_start')">05:00</option>
                               <option value="1730" onclick="startTime('tuesday_start')">05:30</option>
                               <option value="1800" onclick="startTime('tuesday_start')" >06:00</option>
                               <option value="1830" onclick="startTime('tuesday_start')">06:30</option>
                               <option value="1900" onclick="startTime('tuesday_start')">07:00</option>
                               <option value="1930" onclick="startTime('tuesday_start')">07:30</option>
                               <option value="2000" onclick="startTime('tuesday_start')">08:00</option>
                               <option value="2030" onclick="startTime('tuesday_start')">08:30</option>
                               <option value="2100" onclick="startTime('tuesday_start')">09:00</option>
                               <option value="2130" onclick="startTime('tuesday_start')">09:30</option>
                               <option value="2200" onclick="startTime('tuesday_start')">10:00</option>
                           </select></td><td>
               <select name="tuesday_end" id="tuesday_end" value="">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Wednesday:</td><td><select id="wednesday_start" name="wednesday_start" vlaue="">
                               <option value="600" onclick="startTime('wednesday_start')">06:00</option>
                               <option value="630" onclick="startTime('wednesday_start')">06:30</option>
                               <option value="700" onclick="startTime('wednesday_start')">07:00</option>
                               <option value="730" onclick="startTime('wednesday_start')">07:30</option>
                               <option value="800" onclick="startTime('wednesday_start')">08:00</option>
                               <option value="830" onclick="startTime('wednesday_start')">08:30</option>
                               <option value="900" onclick="startTime('wednesday_start')">09:00</option>
                               <option value="930" onclick="startTime('wednesday_start')">09:30</option>
                               <option value="1000" onclick="startTime('wednesday_start')">10:00</option>
                               <option value="1030" onclick="startTime('wednesday_start')">10:30</option>
                               <option value="1100" onclick="startTime('wednesday_start')">11:00</option>
                               <option value="1130" onclick="startTime('wednesday_start')">11:30</option>
                               <option value="1200" onclick="startTime('wednesday_start')">12:00</option>
                               <option value="1230" onclick="startTime('wednesday_start')">12:30</option>
                               <option value="1300" onclick="startTime('wednesday_start')">01:00</option>
                               <option value="1330" onclick="startTime('wednesday_start')">01:30</option>
                               <option value="1400" onclick="startTime('wednesday_start')">02:00</option>
                               <option value="1450" onclick="startTime('wednesday_start')">02:30</option>
                               <option value="1500" onclick="startTime('wednesday_start')">03:00</option>
                               <option value="1530" onclick="startTime('wednesday_start')">03:30</option>
                               <option value="1600" onclick="startTime('wednesday_start')">04:00</option>
                               <option value="1630" onclick="startTime('wednesday_start')">04:30</option>
                               <option value="1700" onclick="startTime('wednesday_start')">05:00</option>
                               <option value="1730" onclick="startTime('wednesday_start')">05:30</option>
                               <option value="1800" onclick="startTime('wednesday_start')">06:00</option>
                               <option value="1830" onclick="startTime('wednesday_start')">06:30</option>
                               <option value="1900" onclick="startTime('wednesday_start')">07:00</option>
                               <option value="1930" onclick="startTime('wednesday_start')">07:30</option>
                               <option value="2000" onclick="startTime('wednesday_start')">08:00</option>
                               <option value="2030" onclick="startTime('wednesday_start')">08:30</option>
                               <option value="2100" onclick="startTime('wednesday_start')">09:00</option>
                               <option value="2130" onclick="startTime('wednesday_start')">09:30</option>
                               <option value="2200" onclick="startTime('wednesday_start')">10:00</option>
                           </select></td><td>
               <select name="wednesday_end" id="wednesday_end" value="">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Thursday:</td><td><select id="thursday_start" name="thursday_start" value="">
                               <option value="600" onclick="startTime('thursday_start')">06:00</option>
                               <option value="630" onclick="startTime('thursday_start')">06:30</option>
                               <option value="700" onclick="startTime('thursday_start')">07:00</option>
                               <option value="730" onclick="startTime('thursday_start')">07:30</option>
                               <option value="800" onclick="startTime('thursday_start')">08:00</option>
                               <option value="830" onclick="startTime('thursday_start')">08:30</option>
                               <option value="900" onclick="startTime('thursday_start')">09:00</option>
                               <option value="930" onclick="startTime('thursday_start')">09:30</option>
                               <option value="1000" onclick="startTime('thursday_start')">10:00</option>
                               <option value="1030" onclick="startTime('thursday_start')">10:30</option>
                               <option value="1100" onclick="startTime('thursday_start')">11:00</option>
                               <option value="1130" onclick="startTime('thursday_start')">11:30</option>
                               <option value="1200" onclick="startTime('thursday_start')">12:00</option>
                               <option value="1230" onclick="startTime('thursday_start')">12:30</option>
                               <option value="1300" onclick="startTime('thursday_start')">01:00</option>
                               <option value="1330" onclick="startTime('thursday_start')">01:30</option>
                               <option value="1400" onclick="startTime('thursday_start')">02:00</option>
                               <option value="1450" onclick="startTime('thursday_start')">02:30</option>
                               <option value="1500" onclick="startTime('thursday_start')">03:00</option>
                               <option value="1530" onclick="startTime('thursday_start')">03:30</option>
                               <option value="1600" onclick="startTime('thursday_start')">04:00</option>
                               <option value="1630" onclick="startTime('thursday_start')">04:30</option>
                               <option value="1700" onclick="startTime('thursday_start')">05:00</option>
                               <option value="1730" onclick="startTime('thursday_start')">05:30</option>
                               <option value="1800" onclick="startTime('thursday_start')">06:00</option>
                               <option value="1830" onclick="startTime('thursday_start')">06:30</option>
                               <option value="1900" onclick="startTime('thursday_start')">07:00</option>
                               <option value="1930" onclick="startTime('thursday_start')">07:30</option>
                               <option value="2000" onclick="startTime('thursday_start')">08:00</option>
                               <option value="2030" onclick="startTime('thursday_start')">08:30</option>
                               <option value="2100" onclick="startTime('thursday_start')">09:00</option>
                               <option value="2130" onclick="startTime('thursday_start')">09:30</option>
                               <option value="2200" onclick="startTime('thursday_start')">10:00</option>
                           </select></td><td>
               <select name="thursday_end" id="thursday_end" value="">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Friday:</td><td><select id="friday_start" name="friday_start" value="">
                               <option value="600" onclick="startTime('friday_start')">06:00</option>
                               <option value="630" onclick="startTime('friday_start')">06:30</option>
                               <option value="700" onclick="startTime('friday_start')">07:00</option>
                               <option value="730" onclick="startTime('friday_start')">07:30</option>
                               <option value="800" onclick="startTime('friday_start')">08:00</option>
                               <option value="830" onclick="startTime('friday_start')">08:30</option>
                               <option value="900" onclick="startTime('friday_start')">09:00</option>
                               <option value="930" onclick="startTime('friday_start')">09:30</option>
                               <option value="1000" onclick="startTime('friday_start')">10:00</option>
                               <option value="1030" onclick="startTime('friday_start')">10:30</option>
                               <option value="1100" onclick="startTime('friday_start')">11:00</option>
                               <option value="1130" onclick="startTime('friday_start')">11:30</option>
                               <option value="1200" onclick="startTime('friday_start')">12:00</option>
                               <option value="1230" onclick="startTime('friday_start')">12:30</option>
                               <option value="1300" onclick="startTime('friday_start')">01:00</option>
                               <option value="1330" onclick="startTime('friday_start')">01:30</option>
                               <option value="1400" onclick="startTime('friday_start')">02:00</option>
                               <option value="1450" onclick="startTime('friday_start')">02:30</option>
                               <option value="1500" onclick="startTime('friday_start')">03:00</option>
                               <option value="1530" onclick="startTime('friday_start')">03:30</option>
                               <option value="1600" onclick="startTime('friday_start')">04:00</option>
                               <option value="1630" onclick="startTime('friday_start')">04:30</option>
                               <option value="1700" onclick="startTime('friday_start')">05:00</option>
                               <option value="1730" onclick="startTime('friday_start')">05:30</option>
                               <option value="1800" onclick="startTime('friday_start')">06:00</option>
                               <option value="1830" onclick="startTime('friday_start')">06:30</option>
                               <option value="1900" onclick="startTime('friday_start')">07:00</option>
                               <option value="1930" onclick="startTime('friday_start')">07:30</option>
                               <option value="2000" onclick="startTime('friday_start')">08:00</option>
                               <option value="2030" onclick="startTime('friday_start')">08:30</option>
                               <option value="2100" onclick="startTime('friday_start')">09:00</option>
                               <option value="2130" onclick="startTime('friday_start')">09:30</option>
                               <option value="2200" onclick="startTime('friday_start')">10:00</option>
                           </select></td><td>
               <select name="friday_end" id="friday_end" value="">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Saturday:</td><td><select id="saturday_start" name="saturday_start" value="">
                               <option value="600" onclick="startTime('saturday_start')">06:00</option>
                               <option value="630" onclick="startTime('saturday_start')">06:30</option>
                               <option value="700" onclick="startTime('saturday_start')">07:00</option>
                               <option value="730" onclick="startTime('saturday_start')">07:30</option>
                               <option value="800" onclick="startTime('saturday_start')">08:00</option>
                               <option value="830" onclick="startTime('saturday_start')">08:30</option>
                               <option value="900" onclick="startTime('saturday_start')">09:00</option>
                               <option value="930" onclick="startTime('saturday_start')">09:30</option>
                               <option value="1000" onclick="startTime('saturday_start')">10:00</option>
                               <option value="1030" onclick="startTime('saturday_start')">10:30</option>
                               <option value="1100" onclick="startTime('saturday_start')">11:00</option>
                               <option value="1130" onclick="startTime('saturday_start')">11:30</option>
                               <option value="1200" onclick="startTime('saturday_start')">12:00</option>
                               <option value="1230" onclick="startTime('saturday_start')">12:30</option>
                               <option value="1300" onclick="startTime('saturday_start')">01:00</option>
                               <option value="1330" onclick="startTime('saturday_start')">01:30</option>
                               <option value="1400" onclick="startTime('saturday_start')">02:00</option>
                               <option value="1450" onclick="startTime('saturday_start')">02:30</option>
                               <option value="1500" onclick="startTime('saturday_start')">03:00</option>
                               <option value="1530" onclick="startTime('saturday_start')">03:30</option>
                               <option value="1600" onclick="startTime('saturday_start')">04:00</option>
                               <option value="1630" onclick="startTime('saturday_start')">04:30</option>
                               <option value="1700" onclick="startTime('saturday_start')">05:00</option>
                               <option value="1730" onclick="startTime('saturday_start')">05:30</option>
                               <option value="1800" onclick="startTime('saturday_start')">06:00</option>
                               <option value="1830" onclick="startTime('saturday_start')">06:30</option>
                               <option value="1900" onclick="startTime('saturday_start')">07:00</option>
                               <option value="1930" onclick="startTime('saturday_start')">07:30</option>
                               <option value="2000" onclick="startTime('saturday_start')">08:00</option>
                               <option value="2030" onclick="startTime('saturday_start')">08:30</option>
                               <option value="2100" onclick="startTime('saturday_start')">09:00</option>
                               <option value="2130" onclick="startTime('saturday_start')">09:30</option>
                               <option value="2200" onclick="startTime('saturday_start')">10:00</option>
                           </select></td><td>
               <select name="saturday_end" id="saturday_end" value="">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Sunday:</td><td><select id="sunday_start" name="sunday_start" value="">
                               <option value="600" onclick="startTime('sunday_start')">06:00</option>
                               <option value="630" onclick="startTime('sunday_start')">06:30</option>
                               <option value="700" onclick="startTime('sunday_start')">07:00</option>
                               <option value="730" onclick="startTime('sunday_start')">07:30</option>
                               <option value="800" onclick="startTime('sunday_start')">08:00</option>
                               <option value="830" onclick="startTime('sunday_start')">08:30</option>
                               <option value="900" onclick="startTime('sunday_start')">09:00</option>
                               <option value="930" onclick="startTime('sunday_start')">09:30</option>
                               <option value="1000" onclick="startTime('sunday_start')">10:00</option>
                               <option value="1030" onclick="startTime('sunday_start')">10:30</option>
                               <option value="1100" onclick="startTime('sunday_start')">11:00</option>
                               <option value="1130" onclick="startTime('sunday_start')">11:30</option>
                               <option value="1200" onclick="startTime('sunday_start')">12:00</option>
                               <option value="1230" onclick="startTime('sunday_start')">12:30</option>
                               <option value="1300" onclick="startTime('sunday_start')">01:00</option>
                               <option value="1330" onclick="startTime('sunday_start')">01:30</option>
                               <option value="1400" onclick="startTime('sunday_start')">02:00</option>
                               <option value="1450" onclick="startTime('sunday_start')">02:30</option>
                               <option value="1500" onclick="startTime('sunday_start')">03:00</option>
                               <option value="1530" onclick="startTime('sunday_start')">03:30</option>
                               <option value="1600" onclick="startTime('sunday_start')">04:00</option>
                               <option value="1630" onclick="startTime('sunday_start')">04:30</option>
                               <option value="1700" onclick="startTime('sunday_start')">05:00</option>
                               <option value="1730" onclick="startTime('sunday_start')">05:30</option>
                               <option value="1800" onclick="startTime('sunday_start')">06:00</option>
                               <option value="1830" onclick="startTime('sunday_start')">06:30</option>
                               <option value="1900" onclick="startTime('sunday_start')">07:00</option>
                               <option value="1930" onclick="startTime('sunday_start')">07:30</option>
                               <option value="2000" onclick="startTime('sunday_start')">08:00</option>
                               <option value="2030" onclick="startTime('sunday_start')" >08:30</option>
                               <option value="2100" onclick="startTime('sunday_start')">09:00</option>
                               <option value="2130" onclick="startTime('sunday_start')">09:30</option>
                               <option value="2200" onclick="startTime('sunday_start')">10:00</option>
                           </select></td><td>
               <select name="sunday_end" id="sunday_end" value="">
                               
                           </select>
                    </td></tr>
                    <tr><td colspan="3"><input type="submit" value="Submit"/></td></tr>
                    <input type="hidden" id="employee_id" name="employee_id" value=""/>
                    <input type="hidden" id="array_index" name="array_index" value=""/>
                </form>
            </table>
        </div>
        <div id="employee_right">
            <table id="employee_table">
                <form>
                    <tr><th id="table_title" colspan="8">Subway Employees</th></tr>

<?php
for ($x = 0; $x < count($_SESSION['employee_array']); $x++) {

    $id = $_SESSION['employee_array'][$x]->getEmployeeID();
    $first = $_SESSION['employee_array'][$x]->getEmployeeFirstName();
    $last = $_SESSION['employee_array'][$x]->getEmployeeLastName();
    $email = $_SESSION['employee_array'][$x]->getEmployeeEmail();
    $emp_type = $_SESSION['employee_array'][$x]->getEmployeeType();
    $emp_minor = $_SESSION['employee_array'][$x]->getEmployeeMinor();
    $mon_start = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getMondayStart();
    $mon_end = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getMondayEnd();
    $tues_start = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getTuesdayStart();
    $tues_end = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getTuesdayEnd();
    $wed_start = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getWednesdayStart();
    $wed_end = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getWednesdayEnd();
    $thurs_start = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getThursdayStart();
    $thurs_end = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getThursdayEnd();
    $fri_start = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getFridayStart();
    $fri_end = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getFridayEnd();
    $sat_start = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getSaturdayStart();
    $sat_end = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getSaturdayEnd();
    $sun_start = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getSundayStart();
    $sun_end = $_SESSION['employee_array'][$x]->getEmployeeAvailability()->getSundayEnd();

    echo"<tr><td class='employee_table'><input type='radio' id='employee' name='employee' onclick = 'insertEmployee($x,\"$id\",
        \"$first\",\"$last\",\"$email\",\"$emp_minor\",\"$emp_type\",\"$mon_start\",\"$mon_end\",\"$tues_start\",
        \"$tues_end\",\"$wed_start\",\"$wed_end\",\"$thurs_start\",\"$thurs_end\",\"$fri_start\",\"$fri_end\",
        \"$sat_start\",\"$sat_end\",\"$sun_start\",\"$sun_end\");' value=''></td>";
                                    
    echo "<td class='employee_table'>";
    echo $first;
    echo "</td><td class='employee_table'>";
    echo $last;
    echo "</td><td class='employee_table'>";
    echo $email;
    echo "</td><td class='employee_table'>";
    echo $emp_type;
    echo "</td><td class='employee_table'>";
    echo $emp_minor;
    echo"</td></tr>";
}
?>
                </form>
            </table>
        </div>
    </div>
    </div>
</body>
</html>

<script language="Javascript">
   
    /*
     * The insertEmployee method will take the array index that the user selected along
     * with the first, last, email, minor, and type of that employee in the existing 
     * employee table. These values will then be inserted into the form that allows
     * the user to modify employees. This should lead to less input errors as the user
     * will only have to modify the fields that need modification. Everything else is 
     * plugged in for them. 
     */
    function insertEmployee(index,id,first,last,email,emp_minor,emp_type,mon_start,mon_end,tues_start,tues_end,wed_start,wed_end,
                                thurs_start,thurs_end,fri_start,fri_end,sat_start,sat_end,sun_start,sun_end){
       
        var first_name = first;
        var last_name = last; 
        var email = email;
        var emp_minor = emp_minor;
        var emp_type = emp_type;
        var array_index = index; 
        var employee_id = id;
        
        var mon_start = mon_start;
        var mon_end = mon_end;
        var tues_start = tues_start;
        var tues_end = tues_end;
        var wed_start = wed_start;
        var wed_end = wed_end;
        var thurs_start = thurs_start;
        var thurs_end = thurs_end;
        var fri_start = fri_start;
        var fri_end = fri_end;
        var sat_start = sat_start;
        var sat_end = sat_end;
        var sun_start = sun_start;
        var sun_end = sun_end;
         
        document.getElementById('first_name').value = first_name;
        document.getElementById('last_name').value = last_name;
        document.getElementById('email').value = email;
        document.getElementById('emp_minor').value = emp_minor;
        document.getElementById('emp_type').value = emp_type;
        
        document.getElementById('monday_start').value = mon_start;
        document.getElementById('monday_end').value = mon_end;
        document.getElementById('tuesday_start').value = tues_start;
        document.getElementById('tuesday_end').value = tues_end;
        document.getElementById('wednesday_start').value = wed_start;
        document.getElementById('wednesday_end').value = wed_end;
        document.getElementById('thursday_start').value = thurs_start;
        document.getElementById('thursday_end').value = thurs_end;
        document.getElementById('friday_start').value = fri_start;
        document.getElementById('friday_end').value = fri_end;
        document.getElementById('saturday_start').value = sat_start;
        document.getElementById('saturday_end').value = sat_end;
        document.getElementById('sunday_start').value = sun_start;
        document.getElementById('sunday_end').value = sun_end;
        
        document.getElementById('array_index').value = array_index;
        document.getElementById('employee_id').value = employee_id;
        
    }
    
    function startTime(select_name){
        
        if(select_name == "monday_start"){
            var start_time_selected = document.getElementById("monday_start").value;
            var start_time_list = document.getElementById("monday_start");
            var end_time_list = document.getElementById("monday_end");
        }
        
        if(select_name == "tuesday_start"){
            var start_time_selected = document.getElementById("tuesday_start").value;
            var start_time_list = document.getElementById("tuesday_start");
            var end_time_list = document.getElementById("tuesday_end");
        }
        if(select_name == "wednesday_start"){
            var start_time_selected = document.getElementById("wednesday_start").value;
            var start_time_list = document.getElementById("wednesday_start");
            var end_time_list = document.getElementById("wednesday_end");
        }
        if(select_name == "thursday_start"){
            var start_time_selected = document.getElementById("thursday_start").value;
            var start_time_list = document.getElementById("thursday_start");
            var end_time_list = document.getElementById("thursday_end");
        }
        if(select_name == "friday_start"){
            var start_time_selected = document.getElementById("friday_start").value;
            var start_time_list = document.getElementById("friday_start");
            var end_time_list = document.getElementById("friday_end");
        }
        if(select_name == "saturday_start"){
            var start_time_selected = document.getElementById("saturday_start").value;
            var start_time_list = document.getElementById("saturday_start");
            var end_time_list = document.getElementById("saturday_end");
        }
        if(select_name == "sunday_start"){
            var start_time_selected = document.getElementById("sunday_start").value;
            var start_time_list = document.getElementById("sunday_start");
            var end_time_list = document.getElementById("sunday_end");
        }
       
        //Get index location of the selected start time.
        for(var x =0; x < start_time_list.options.length;x++){
            if(start_time_list.options[x].value == start_time_selected){
                var index;
                index = x;
            }
        }
        
        var slots_to_add = start_time_list.options.length - index;
       
        end_time_list.options.length=0;
        
        for(var i =0; i < slots_to_add; i++){
            
            var option = document.createElement("Option");
            option.text = start_time_list.options[index].text;
            option.value = start_time_list.options[index].value;
            end_time_list.options[i] = option;
            index++;   
        }        
    }
</script>