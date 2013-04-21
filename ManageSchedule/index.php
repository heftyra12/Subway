<?php
session_start();

if($_SESSION['current_prod'] != true){
    header("Location: productivity.php");
}
include_once '../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/getBusinessRules.php';
include_once'../../Subway/HelperFiles/scheduleClass.php';
include_once '../../Subway/HelperFiles/employeeClass.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';
include_once '../../Subway/HelperFiles/shiftClass.php';

$sqlCommand = "SELECT employee_id, first_name, last_name, emp_type, emp_minor from subway.employee";

$result = mysqli_query($db_connect, $sqlCommand);

$schedule_array = array();
$full_sched_array = array();

while ($row = mysqli_fetch_array($result)) {

    $employee = new employeeClass;
    $schedule = new scheduleClass;
    
    $employee->setEmployeeID($row["employee_id"]);
    $employee->setEmployeeFirstName($row["first_name"]);
    
    $schedule->setEmployeeID($row["employee_id"]);
    $schedule->setFirstName($row["first_name"]);
    $schedule->setLastName($row["last_name"]);
    
    $employee->setEmployeeLastName($row["last_name"]);
    $employee->setEmployeeType($row["emp_type"]);
    $employee->setEmployeeMinor($row["emp_minor"]);
    
    array_push($full_sched_array,$schedule);
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
                <li><a href="/MainMenu/index.php">Home</a></li>
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
            <div id="left_buttons">
                <form action="productivity.php" method="POST">
                    <input type="submit" value="Enter Productivity" class="subway_buttons"/>
                </form>
                
                    <br/>
                    <br/>
            
                <form action="shifts.php" method="POST">
                    <input type="submit" value="Schedule Shifts" class="subway_buttons"/>
                </form>
            </div>
        </div>

        <div id="normal_right">
           
            <div id="home_sched">   
                
                <form action="/HelperFiles/validateSchedule.php" method="POST">
                
                    <table class="schedule_table">
                 
                        <tr class="schedule_table">
                            <th id="table_title" colspan="15">Create New Schedule:</th>
                        </tr>
               
                        <tr class="schedule_table">
                            <th class="schedule_table">Employee:</th>
                            <th class="schedule_table">Wednesday:</th>
                            <th class="schedule_table">Thursday:</th>
                            <th class="schedule_table">Friday:</th>
                            <th class="schedule_table">Saturday:</th>
                            <th class="schedule_table">Sunday:</th>
                            <th class="schedule_table">Monday:</th>
                            <th class="schedule_table">Tuesday:</th>
                        </tr>             
                <?php
                    
                    $array = array(1,2,3,4,5,6,7);
                
                    for($x=0;$x<count($_SESSION['schedule_array']);$x++){
                        
                        $isMinor = $_SESSION['schedule_array'][$x]->getEmployeeMinor();
                        $emp_type = $_SESSION['schedule_array'][$x]->getEmployeeType();
                        
                        echo "<input type='hidden' id='test'>";
                        echo "<tr class='schedule_table'><td class='sched_emp'>";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeFirstName()." ";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeLastName()."</td>";
                            
                        echo "<td><select id='wed_start_$x' name='wed_start_$x' onChange='mainCall(name);' class='schedule_table'>";
                        echo "<option value='default'>start</option>";
                        
                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                            ":00-",(substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),":00")as shift
                            From subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['shift'] . "' id='shift' name='shift' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select id='wed_end_$x' name='wed_end_$x' onChange='endMainCall(name);' class='schedule_table_end'>";
                        
                        echo "<option value='default'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        
                        echo "<td><select id='thu_start_$x' name='thu_start_$x' onChange='resetTime(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='default'>start</option>";
                        
                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                            ":00-",(substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),":00")as shift
                            From subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['shift'] . "' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select id='thu_end_$x' name='thu_end_$x' onChange='resetTime(name);'class='schedule_table_end'>";
                        echo "<option value='default'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td><select id='fri_start_$x' name='fri_start_$x' onChange='resetTime(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='default'>start</option>";
                        
                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                            ":00-",(substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),":00")as shift
                            From subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['shift'] . "'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select id='fri_end_$x' name='fri_end_$x' onChange='resetTime(name);' class='schedule_table_end'>";
                        echo "<option value='default'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td><select id='sat_start_$x' name='sat_start_$x' onChange='resetTime(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='default'>start</option>";
                        
                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                            ":00-",(substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),":00")as shift
                            From subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['shift'] . "'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select id='sat_end_$x' name='sat_end_$x' onChange='resetTime(name);' class='schedule_table_end'>";
                        echo "<option value='default'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td><select id='sun_start_$x' name='sun_start_$x' onChange='resetTime(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='default'>start</option>";
                        
                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                            ":00-",(substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),":00")as shift
                            From subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['shift'] . "'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select id='sun_end_$x' name='sun_end_$x' onChange='resetTime(name);' class='schedule_table_end'>";
                        echo "<option value='default'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td><select id='mon_start_$x' name='mon_start_$x' onChange='resetTime(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='default'>start</option>";
                        
                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                            ":00-",(substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),":00")as shift
                            From subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['shift'] . "'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select id='mon_end_$x' name='mon_end_$x' onChange='resetTime(name);' class='schedule_table_end'>";
                        echo "<option value='default'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td><select id='tue_start_$x' name='tue_start_$x' onChange='resetTime(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='default'>start</option>";
                        
                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                            ":00-",(substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),":00")as shift
                            From subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['shift'] . "'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select id='tue_end_$x' name='tue_end_$x' onChange='resetTime(name);' class='schedule_table_end'>";
                        echo "<option value='default'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='850'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='950'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1050'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1150'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1250'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1350'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1450'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1550'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1650'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1750'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1850'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1950'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2050'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2150'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        echo "</tr>";
                         
                        echo "<input type='hidden' id='type_$x' name='type_$x' value=\"$emp_type\">";
                        echo "<input type='hidden' id='minor_$x' name='minor_$x' value=\"$isMinor\">";
                        
                        echo "<input type='hidden' id='mon_time_start_$x' name='mon_time_start_$x' value=''>";
                        echo "<input type='hidden' id='mon_time_end_$x' name='mon_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='tue_time_start_$x' name='tue_time_start_$x' value=''>";
                        echo "<input type='hidden' id='tue_time_end_$x' name='tue_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='wed_time_start_$x' name='wed_time_start_$x' value=''>";
                        echo "<input type='hidden' id='wed_time_end_$x' name='wed_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='thr_time_start_$x' name='thu_time_start_$x' value=''>";
                        echo "<input type='hidden' id='thr_time_end_$x' name='thu_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='fri_time_start_$x' name='fri_time_start_$x' value=''>";
                        echo "<input type='hidden' id='fri_time_end_$x' name='fri_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='sat_time_start_$x' name='sat_time_start_$x' value=''>";
                        echo "<input type='hidden' id='sat_time_end_$x' name='sat_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='sun_time_start_$x' name='sun_time_start_$x' value=''>";
                        echo "<input type='hidden' id='sun_time_end_$x' name='sun_time_end_$x' value=''>";
                     
                        echo "<input type='hidden' id='total_$x' name='total_$x' value=''>";
                    }
                    
                    echo "<input type='hidden' id='index' name='index' value='$x'>";
                   
                ?>
                        
                <tr><td colspan="9"><input type="submit" value="Create Schedule:"/></td></tr>  
                </form>
                </table>
            </div>
        </div>
    </div>
    </div>
</body>
</html>

<script language="Javascript">
    
    function mainCall(table){
        
        var name = table;
        resetTime(name);
        if(checkTime(name))
            timeCheck(name);   
    }
    
    function endMainCall(table){
        var name = table; 
        resetTime(name);
        timeCheck(name);
    }
 
    
    function resetTime(table){
        
        var table_name = table.split("_");
        
        var start_name = table_name[0]+"_start_"+table_name[2];
        var end_name = table_name[0]+"_end_"+table_name[2];
        
        var table_one = document.getElementById(start_name);
        var table_two = document.getElementById(end_name);
       
        if(table_one.value.length > 8 || table_two.value.lengh > 8){
            document.getElementById(end_name).value="default";
        }
    }
    
    function checkTime(table){
        
        var table_name = table.split("_");
        
        var start_name = table_name[0]+"_start_"+table_name[2];
        var end_name = table_name[0]+"_end_"+table_name[2];
        
        var table_one = document.getElementById(start_name);
        var table_two = document.getElementById(end_name);
        
        var min_shift_hours = document.getElementById('min_shift_hours').value; 
        
        for(var x = 0; x < table_one.length; x++){
            
            if(table_one.value == table_two[x].value){
                
                if(x < table_two.length - (min_shift_hours * 2)){
                    
                    table_two.value = table_two[x+ (min_shift_hours * 2)].value;
                    return true;
                }
                else{
                    table_one.value="default";
                    table_two.value="default";
                    alert("Minimum Shift Time Is " + min_shift_hours);
                    return true;
                }   
            }
        }
        return true;
    }
    
    function timeCheck(table){
   
        var max_day_part = document.getElementById('max_day_part').value;
        var max_day_full = document.getElementById('max_day_full').value;
        
        var table_name = table.split("_");
        
        var start_name = table_name[0]+"_start_"+table_name[2];
        var end_name = table_name[0]+"_end_"+table_name[2];
        
        var start_time = document.getElementById(start_name).value;
        var end_time = document.getElementById(end_name).value;
        
        var index = table_name[2];
      
        var day = table_name[0];
        alert(day);
        
        var type = "type_"+index;
        
        var emp_type = document.getElementById(type).value;
        
        if(emp_type == "F"){
        
            if(end_time != "default"){
                
                if((end_time - start_time) > (max_day_full * 100)){
                    alert("over on hours");
                }
                else{
                    switch(day){
                        
                        case "wed":
                            document.getElementById("wed_time_start_"+index).value = start_time;
                            document.getElementById("wed_time_end_"+index).value = end_time;
                            alert(index);
                        case "thu":
                            document.getElementById("thr_start_time_"+index).value = start_time;
                            document.getElementById("thr_start_time_"+index).value=end_time;
                        case "fri":
                        case "sat":
                        case "sun":
                        case "mon":
                        case "tue":
                        
                    }
                    
                }
            }
        }
        if(emp_type =="P"){
        
            if(end_time != "default"){
                
                if((end_time - start_time) > (max_day_part *100)){
                    alert("Part-Time Over Hours:");
                }
            }
        }  
    }
</script>
    
