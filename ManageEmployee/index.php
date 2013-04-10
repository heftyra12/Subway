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
$sqlCommand = 'SELECT employee_id,first_name,last_name,email,emp_type,emp_minor FROM subway.employee';

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

$sqlCommand = 'SELECT employee_id,monday_start,monday_end,tuesday_start,tuesday_end,wednesday_start,wednesday_end,thursday_start,thursday_end,friday_start,friday_end,
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
                <th class="emp_title" colspan="4">Edit Employees:</th>
                <form action="/HelperFiles/validateEmployee.php" method="POST">

                    <tr><td colspan="3">First Name:<input type="text" id="first_name" name="first_name" value="<?php echo $_SESSION['first_name'];?>" required/></td></tr>
                    <tr><td colspan="3">Last Name:<input type="text" id="last_name" name="last_name" value="<?php echo $_SESSION['last_name'];?>"required/></td></tr>
                    <tr><td colspan="3">Email:<input type="text" id="email" name="email" value="<?php echo $_SESSION['email']?>" required/></td></tr>
                    
                    <tr><td colspan="3">Type:<select id="employee_type" name="emp_type" value="<?php echo $_SESSION['emp_type']; ?>"/>
                                                <option value="Full-Time">Full-Time</option>
                                                <option value="Part-Time">Part-Time</option>
                                                <option value="Manager">Manager</option>
                                            </select></td></tr>
                    <tr><td colspan="3">Minor:<select id="minor" name="emp_minor" value="<?php echo $_SESSION['emp_minor'];?>"/>
                                                 <option value="No">No</option>
                                                 <option value="Yes">Yes</option>
                                            </select></td></tr>
                    <tr><td colspan="3">Action:<select id="update_option" name="update_option" value="<?php echo $_SESSION['update_option'];?>"/>
                                                <option value="Add">Add</option>
                                                <option value="Update">Update</option>
                                                <option value="Delete">Delete</option>
                                            </select></td></tr>
                    <tr><td>Availability:</td><td>Start:</td><td>End:</td></tr>
                                    
                    <tr><td>Monday:</td><td>
                           <select id="monday_start" name="monday_start" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">1:00</option>
                               <option value="1330">1:30</option>
                               <option value="1400">2:00</option>
                               <option value="1450">2:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select></td><td>
               <select name="monday_end" id="monday_end" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select>
                    </td></tr>
                    <tr><td>
                           Tuesday:</td><td><select id="tuesday_start" name="tuesday_start" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select></td><td>
               <select name="tuesday_end" id="tuesday_end" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select>
                    </td></tr>
                    <tr><td>
                           Wednesday:</td><td><select id="wednesday_start" name="wednesday_start" vlaue="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select></td><td>
               <select name="wednesday_end" id="wednesday_end" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select>
                    </td></tr>
                    <tr><td>
                           Thursday:</td><td><select id="thursday_start" name="thursday_start" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select></td><td>
               <select name="thursday_end" id="thursday_end" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select>
                    </td></tr>
                    <tr><td>
                           Friday:</td><td><select id="friday_start" name="friday_start" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select></td><td>
               <select name="friday_end" id="friday_end" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select>
                    </td></tr>
                    <tr><td>
                           Saturday:</td><td><select id="saturday_start" name="saturday_start" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select></td><td>
               <select name="saturday_end" id="saturday_end" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select>
                    </td></tr>
                    <tr><td>
                           Sunday:</td><td><select id="sunday_start" name="sunday_start" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select></td><td>
               <select name="sunday_end" id="sunday_end" value="">
                               <option value="600">06:00</option>
                               <option value="630">06:30</option>
                               <option value="700">07:00</option>
                               <option value="730">07:30</option>
                               <option value="800">08:00</option>
                               <option value="830">08:30</option>
                               <option value="900">09:00</option>
                               <option value="930">09:30</option>
                               <option value="1000">10:00</option>
                               <option value="1030">10:30</option>
                               <option value="1100">11:00</option>
                               <option value="1130">11:30</option>
                               <option value="1200">12:00</option>
                               <option value="1230">12:30</option>
                               <option value="1300">01:00</option>
                               <option value="1330">01:30</option>
                               <option value="1400">02:00</option>
                               <option value="1450">02:30</option>
                               <option value="1500">03:00</option>
                               <option value="1530">03:30</option>
                               <option value="1600">04:00</option>
                               <option value="1630">04:30</option>
                               <option value="1700">05:00</option>
                               <option value="1730">05:30</option>
                               <option value="1800">06:00</option>
                               <option value="1830">06:30</option>
                               <option value="1900">07:00</option>
                               <option value="1930">07:30</option>
                               <option value="2000">08:00</option>
                               <option value="2030">08:30</option>
                               <option value="2100">09:00</option>
                               <option value="2130">09:30</option>
                               <option value="2200">10:00</option>
                           </select>
                    </td></tr>
                    <tr><td colspan="3"><input type="submit" value="Submit"/></td></tr>
                    <input type="hidden" id="employee_id" name="employee_id" value=""/>
                    <input type="hidden" id="array_index" name="array_index" value=""/>
                </form>
            </table>
        </div>
        <div id="employee_right">
            <table class="employee_table">
                <form>
                    <tr><th class="emp_title" colspan="8">Subway Employees</th></tr>

<?php
for ($x = 0; $x < count($_SESSION['employee_array']); $x++) {

    $id = $_SESSION['employee_array'][$x]->getEmployeeID();
    $first = $_SESSION['employee_array'][$x]->getEmployeeFirstName();
    $last = $_SESSION['employee_array'][$x]->getEmployeeLastName();
    $email = $_SESSION['employee_array'][$x]->getEmployeeEmail();
    $type = $_SESSION['employee_array'][$x]->getEmployeeType();
    $minor = $_SESSION['employee_array'][$x]->getEmployeeMinor();
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
                                  \"$first\",\"$last\",\"$email\",\"$minor\",\"$type\",\"$mon_start\",\"$mon_end\",\"$tues_start\",
                                   \"$tues_end\",\"$wed_start\",\"$wed_end\",\"$thurs_start\",\"$thurs_end\",\"$fri_start\",\"$fri_end\",
                                       \"$sat_start\",\"$sat_end\",\"$sun_start\",\"$sun_end\");' value=''></td>";
                                    
    echo "<td class='employee_table'>";
    echo $first;
    echo "</td><td class='employee_table'>";
    echo $last;
    echo "</td><td class='employee_table'>";
    echo $email;
    echo "</td><td class='employee_table'>";
    echo $type;
    echo "</td><td class='employee_table'>";
    echo $minor;
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
    function insertEmployee(index,id,first,last,email,minor,type,mon_start,mon_end,tues_start,tues_end,wed_start,wed_end,
                                thurs_start,thurs_end,fri_start,fri_end,sat_start,sat_end,sun_start,sun_end){
       
        var first_name = first;
        var last_name = last; 
        var email = email;
        var minor = minor;
        var type = type;
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
        document.getElementById('minor').value = minor;
        document.getElementById('employee_type').value = type;
        
        document.getElementById('monday_start').value = mon_start
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
</script>