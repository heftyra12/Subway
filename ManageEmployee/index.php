<?php
session_start();

include_once '../../Subway/HelperFiles/employeeClass.php';
include_once '../../Subway/HelperFiles/Availability.php';
include_once '../../Subway/HelperFiles/config.php';

//Variables to hold textfield data / input errors

if(!isset($_SESSION['first_name']))
    $_SESSION['first_name']= "";
if(!isset($_SESSION['last_name']))
    $_SESSION['last_name']= "";
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
        <script type="text/javascript" src="/HelperFiles/JS/setTime.js"></script>
        <title>Employees</title>
    </head>
    <body>

        <div id="page_top"/>
        
            <div id="log_out">
            User: <?php echo $_SESSION['user_name'];
                        echo " | <a href=../index.php>Logout</a>";
                     ?>
            </div>
        
            <div id="top_image">

                <img src="/Images/temp_top_logo_3.png" id="image" align="center">
            </div>

            <ul class="subway_tabs">
                <li><a href="/MainMenu/index.php">Home</a></li>
                <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
                <li class="current_position">Employees</li>
                <li><a href="/EditRequests/index.php" value="edit_requests">Requests</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules</a></li>
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
                    
                    <tr><td colspan="3">Type:<select id="emp_type" name="emp_type" value="<?php echo $_SESSION['emp_type']; ?>"/>
                                                <option value="F">Full-Time</option>
                                                <option value="P">Part-Time</option>
                                                <option value="M">Manager</option>
                                            </select></td></tr>
                    <tr><td colspan="3">Minor:<select id="emp_minor" name="emp_minor" value="<?php echo $_SESSION['emp_minor'];?>"/>
                                                 <option value="N">No</option>
                                                 <option value="Y">Yes</option>
                                            </select></td></tr>
                    <tr><td>Availability:</td><td>Start:</td><td>End:</td></tr>
                                    
                    <tr><td>Monday:</td><td>
                           <select id="monday_start" name="monday_start" onChange="startTime('monday_start');" class="default_time_drop_down">
                               <option value="default">---</option>
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
               <select name="monday_end" id="monday_end" value="" class="default_time_drop_down" title="Select Start Time First:">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Tuesday:</td><td><select id="tuesday_start" name="tuesday_start" onChange="startTime('tuesday_start');" class="default_time_drop_down">
                               <option value="default">---</option>
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
               <select name="tuesday_end" id="tuesday_end" value="" class="default_time_drop_down" title="Select Start Time First:">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Wednesday:</td><td><select id="wednesday_start" name="wednesday_start" onChange="startTime('wednesday_start');" class="default_time_drop_down">
                               <option value="default">---</option> 
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
               <select name="wednesday_end" id="wednesday_end" value="" class="default_time_drop_down" title="Select Start Time First:">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Thursday:</td><td><select id="thursday_start" name="thursday_start" onChange="startTime('thursday_start');" class="default_time_drop_down">
                                <option value="default">---</option>
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
               <select name="thursday_end" id="thursday_end" value="" class="default_time_drop_down" title="Select Start Time First:">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Friday:</td><td><select id="friday_start" name="friday_start" onChange="startTime('friday_start');" class="default_time_drop_down">
                               <option value="default">---</option>
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
               <select name="friday_end" id="friday_end" value="" class="default_time_drop_down" title="Select Start Time First:">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Saturday:</td><td><select id="saturday_start" name="saturday_start" onChange="startTime('saturday_start');" class="default_time_drop_down">
                               <option value="default">---</option> 
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
               <select name="saturday_end" id="saturday_end" value="" class="default_time_drop_down" title="Select Start Time First:">
                               
                           </select>
                    </td></tr>
                    <tr><td>
                           Sunday:</td><td><select id="sunday_start" name="sunday_start" onChange="startTime('sunday_start');" class="default_time_drop_down">
                               <option value="default">---</option>
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
               <select name="sunday_end" id="sunday_end" value="" class="default_time_drop_down" title="Select Start Time First:">
                               
                           </select>
                    </td></tr>
                    <tr><td colspan="3">Action:<select id="update_option" name="update_option" value=""/>
                                                <option value="Add">Add</option>
                                                <option value="Update">Update</option>
                                                <option value="Delete">Delete</option>
                                            </select></td>
                    </tr>
                    <tr><td colspan="3"><input type="button" value="Reset" onclick="resetForm();"></td></tr>
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
    $emp_type = $_SESSION['employee_array'][$x]->getEmployeeType();
    $emp_minor = $_SESSION['employee_array'][$x]->getEmployeeMinor();
    $mon_start = $_SESSION['employee_array'][$x]->getMondayStart();
    $mon_end = $_SESSION['employee_array'][$x]->getMondayEnd();
    $tues_start = $_SESSION['employee_array'][$x]->getTuesdayStart();
    $tues_end = $_SESSION['employee_array'][$x]->getTuesdayEnd();
    $wed_start = $_SESSION['employee_array'][$x]->getWednesdayStart();
    $wed_end = $_SESSION['employee_array'][$x]->getWednesdayEnd();
    $thurs_start = $_SESSION['employee_array'][$x]->getThursdayStart();
    $thurs_end = $_SESSION['employee_array'][$x]->getThursdayEnd();
    $fri_start = $_SESSION['employee_array'][$x]->getFridayStart();
    $fri_end = $_SESSION['employee_array'][$x]->getFridayEnd();
    $sat_start = $_SESSION['employee_array'][$x]->getSaturdayStart();
    $sat_end = $_SESSION['employee_array'][$x]->getSaturdayEnd();
    $sun_start = $_SESSION['employee_array'][$x]->getSundayStart();
    $sun_end = $_SESSION['employee_array'][$x]->getSundayEnd();

    echo"<tr><td class='employee_table'><input type='radio' id='employee' name='employee' onclick = 'insertEmployee($x,\"$id\",
        \"$first\",\"$last\",\"$emp_minor\",\"$emp_type\",\"$mon_start\",\"$mon_end\",\"$tues_start\",
        \"$tues_end\",\"$wed_start\",\"$wed_end\",\"$thurs_start\",\"$thurs_end\",\"$fri_start\",\"$fri_end\",
        \"$sat_start\",\"$sat_end\",\"$sun_start\",\"$sun_end\"); update();' value=''></td>";
                                    
    echo "<td class='employee_table'>";
    echo $first;
    echo "</td><td class='employee_table'>";
    echo $last;
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

    function update(){
        
        document.getElementById("monday_end").title = "";
        document.getElementById("tuesday_end").title = "";
        document.getElementById("wednesday_end").title = "";
        document.getElementById("thursday_end").title = "";
        document.getElementById("friday_end").title = "";
        document.getElementById("saturday_end").title = "";
        document.getElementById("sunday_end").title = "";
        
        var update_options = document.getElementById("update_option");
        
        update_options.options.length = 0; 
        
        var option = document.createElement("Option");
        option.text = "Update";
        option.value = "Update";
        update_options.options[0] = option;
        
        var option_one = document.createElement("Option");
        option_one.text = "Delete";
        option_one.value = "Delete";
        update_options.options[1] = option_one;
        
    }
    
    function resetForm(){
        
        document.getElementById("first_name").value="";
        document.getElementById("last_name").value="";
        document.getElementById("emp_type").value="F";
        document.getElementById("emp_minor").value="N";
        document.getElementById("wednesday_start").value="default";
        document.getElementById("thursday_start").value="default";
        document.getElementById("friday_start").value="default";
        document.getElementById("saturday_start").value="default";
        document.getElementById("sunday_start").value="default";
        document.getElementById("monday_start").value="default";
        document.getElementById("tuesday_start").value="default";
        
        
        document.getElementById("monday_end").title = "Select Start Time First:";
        document.getElementById("tuesday_end").title = "Select Start Time First:";
        document.getElementById("wednesday_end").title = "Select Start Time First:";
        document.getElementById("thursday_end").title = "Select Start Time First:";
        document.getElementById("friday_end").title = "Select Start Time First:";
        document.getElementById("saturday_end").title = "Select Start Time First:";
        document.getElementById("sunday_end").title = "Select Start Time First:";
        
        document.getElementById("monday_end").options.length=0;
        document.getElementById("tuesday_end").options.length=0;
        document.getElementById("wednesday_end").options.length=0;
        document.getElementById("thursday_end").options.length=0;
        document.getElementById("friday_end").options.length=0;
        document.getElementById("saturday_end").options.length=0;
        document.getElementById("sunday_end").options.length=0;
        
          var update_options = document.getElementById("update_option");
        
        update_options.options.length = 0; 
        
        var option_two = document.createElement("Option");
        option_two.text = "Add";
        option_two.value="Add";
        update_options.options[0] = option_two;
        
        var option = document.createElement("Option");
        option.text = "Update";
        option.value = "Update";
        update_options.options[1] = option;
        
        var option_one = document.createElement("Option");
        option_one.text = "Delete";
        option_one.value = "Delete";
        update_options.options[2] = option_one;
        
    }
</script>