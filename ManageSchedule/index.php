<?php
session_start();

if(!isset($_SESSION['user_name']))
{
    header("Location: ../index.php");
}
//if($_SESSION['current_prod'] != true){
//    header("Location: productivity.php");
//}

date_default_timezone_set('America/Chicago');

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
$count = 0;

while ($row = mysqli_fetch_array($result)) {

    $employee = new employeeClass;
    $schedule = new scheduleClass;
    
    $employee->setEmployeeID($row["employee_id"]);
    $employee->setEmployeeFirstName($row["first_name"]);
    $employee->setEmployeeLastName($row["last_name"]);
    $employee->setEmployeeType($row["emp_type"]);
    $employee->setEmployeeMinor($row["emp_minor"]);
    
    $schedule->setEmployeeID($row["employee_id"]);
    $schedule->setFirstName($row["first_name"]);
    $schedule->setLastName($row["last_name"]);
    
    array_push($full_sched_array,$schedule);
    array_push($schedule_array, $employee);
    $count++;
}

$_SESSION['schedule_array']=$schedule_array;
$_SESSION['full_sched_array']=$full_sched_array;
?>

<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/subway.ico">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>

        <title>Create Schedule</title>
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
                <li><a href="/ManageEmployee/index.php">Employees</a></li>
                <li><a href="/EditRequests/index.php">Requests</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules</a></li>
            </ul>     
        
            <div id="tab_bar">
            
            </div>
   
    <div id="normal_body">
        
        <div id="normal_left">
            <div id="left_buttons">
<!--                <form action="productivity.php" method="POST">
                    <input type="submit" value="Enter Productivity" class="subway_buttons"/>
                </form>
                
                    <br/>
                    <br/>-->
            
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
                        <tr>Week Begins On:
                            <?php
                                $yearNum = date("Y"); 
                                
                                //year
                                echo "<select id='year_sched' name='year_sched' onChange='enableMonth();'>";
                                echo "<option value='default'>YEAR</option>";
                                for($y=$yearNum;$y<($yearNum+2);$y++){
                                    echo "<option value='$y'>$y</option>";
                                }
                                echo "</select>";

                                //month 
                                echo "<select disabled id='month_sched' name='month_sched' onChange='setDaysInMonth();'>";
                                echo "<option value='default'>MONTH</option>";
                                echo "<option value='1'>January</option>";
                                echo "<option value='2'>February</option>";
                                echo "<option value='3'>March</option>";
                                echo "<option value='4'>April</option>";
                                echo "<option value='5'>May</option>";
                                echo "<option value='6'>June</option>";
                                echo "<option value='7'>July</option>";
                                echo "<option value='8'>August</option>";
                                echo "<option value='10'>October</option>";
                                echo "<option value='11'>November</option>";
                                echo "<option value='12'>December</option>";
                                echo "</select>";

                                //day
                                echo "<select disabled id='day_sched' name='day_sched' onChange='displaySchedDays($count);'>";
                                echo "<option value='default'>DAY</option>";
                                echo "</select>";
                                
                                //reset
                                echo"<input type='button' value='RESET' id='reset_day_selector' name='reset_day_selector' onClick='resetDaySelector($count);'/>";
                            ?>
                        </tr>
                        
                        <tr class="schedule_table">
                            <th class="schedule_table">Employee:</th>
                            <th class="schedule_table">Hours</th>
                            <th id="day_num1" class="schedule_table">Wed</th>
                            <th id="day_num2" class="schedule_table">Thu</th>
                            <th id="day_num3" class="schedule_table">Fri</th>
                            <th id="day_num4" class="schedule_table">Sat</th>
                            <th id="day_num5" class="schedule_table">Sun</th>
                            <th id="day_num6" class="schedule_table">Mon</th>
                            <th id="day_num7" class="schedule_table">Tue</th>
                        </tr>             
                <?php
                
                    $array = array(1,2,3,4,5,6,7);
                
                    for($x=0;$x<count($_SESSION['full_sched_array']);$x++){

                        $isMinor = $_SESSION['schedule_array'][$x]->getEmployeeMinor();
                        $emp_type = $_SESSION['schedule_array'][$x]->getEmployeeType();
                        
                        echo "<input type='hidden' id='type_$x' name='type_$x' value=\"$emp_type\">";
                        echo "<input type='hidden' id='minor_$x' name='minor_$x' value=\"$isMinor\">";
                        
                        echo "<input type='hidden' id='test'>";
                        echo "<tr class='schedule_table'><td class='sched_emp' >";
                        echo $_SESSION['full_sched_array'][$x]->getFirstName()." ";
                        echo $_SESSION['full_sched_array'][$x]->getLastName()."</td>";
                        echo "<td><output id='hour_total_$x' name='total_$x' class='hour_total' value=''></output></td>";    
                        
                        echo "<td class='test_td' id='wed_$x'><select disabled id='wed_start_$x' name='wed_start_$x' onChange='mainCall(name);' class='schedule_table'>";
                        echo "<option value='def'>start</option>";

                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, start_time,end_time,
                        concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                        ":", substr(start_time, length(start_time)-1,length(start_time)), "-",
                        (substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),
                        ":", substr(end_time, length(end_time)-1,length(end_time))) as shift from subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['start_time']."_".$row['end_time'] . "' id='shift' name='shift' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select disabled id='wed_end_$x' name='wed_end_$x' onChange='endMainCall(name);' class='schedule_table_end'>";
                        
                        echo "<option value='def'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        

                        echo "<td class='test_td' id='thu_$x'><select disabled id='thu_start_$x' name='thu_start_$x' onChange='mainCall(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='def'>start</option>";
                        
                        $dayNo=2;
                        $sqlShiftSelect = 'select shift_id, start_time,end_time,
                        concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                        ":", substr(start_time, length(start_time)-1,length(start_time)), "-",
                        (substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),
                        ":", substr(end_time, length(end_time)-1,length(end_time))) as shift from subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['start_time']."_".$row['end_time'] . "' id='shift' name='shift' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select disabled id='thu_end_$x' name='thu_end_$x' onChange='endMainCall(name);'class='schedule_table_end'>";
                        echo "<option value='def'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td class='test_td' id='fri_$x'><select disabled id='fri_start_$x' name='fri_start_$x' onChange='mainCall(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='def'>start</option>";
                        
                        $dayNo=3;
                        $sqlShiftSelect = 'select shift_id, start_time,end_time,
                        concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                        ":", substr(start_time, length(start_time)-1,length(start_time)), "-",
                        (substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),
                        ":", substr(end_time, length(end_time)-1,length(end_time))) as shift from subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['start_time']."_".$row['end_time'] . "' id='shift' name='shift' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select disabled id='fri_end_$x' name='fri_end_$x' onChange='endMainCall(name);' class='schedule_table_end'>";
                        echo "<option value='def'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td class='test_td' id='sat_$x'><select disabled id='sat_start_$x' name='sat_start_$x' onChange='mainCall(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='def'>start</option>";
                        
                        $dayNo=4;
                       $sqlShiftSelect = 'select shift_id, start_time,end_time,
                        concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                        ":", substr(start_time, length(start_time)-1,length(start_time)), "-",
                        (substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),
                        ":", substr(end_time, length(end_time)-1,length(end_time))) as shift from subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['start_time']."_".$row['end_time'] . "' id='shift' name='shift' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                           echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select disabled id='sat_end_$x' name='sat_end_$x' onChange='endMainCall(name);' class='schedule_table_end'>";
                        echo "<option value='def'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td class='test_td' id='sun_$x'><select disabled id='sun_start_$x' name='sun_start_$x' onChange='mainCall(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='def'>start</option>";
                        
                        $dayNo=5;
                        $sqlShiftSelect = 'select shift_id, start_time,end_time,
                        concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                        ":", substr(start_time, length(start_time)-1,length(start_time)), "-",
                        (substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),
                        ":", substr(end_time, length(end_time)-1,length(end_time))) as shift from subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['start_time']."_".$row['end_time'] . "' id='shift' name='shift' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select disabled id='sun_end_$x' name='sun_end_$x' onChange='endMainCall(name);' class='schedule_table_end'>";
                        echo "<option value='def'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td class='test_td' id='mon_$x'><select disabled id='mon_start_$x' name='mon_start_$x' onChange='mainCall(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='def'>start</option>";
                        
                        $dayNo=6;
                        $sqlShiftSelect = 'select shift_id, start_time,end_time,
                        concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                        ":", substr(start_time, length(start_time)-1,length(start_time)), "-",
                        (substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),
                        ":", substr(end_time, length(end_time)-1,length(end_time))) as shift from subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['start_time']."_".$row['end_time'] . "' id='shift' name='shift' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        
                       echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select disabled id='mon_end_$x' name='mon_end_$x' onChange='endMainCall(name);' class='schedule_table_end'>";
                        echo "<option value='def'>end</option>";
                       echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<td class='test_td' id='tue_$x'><select disabled id='tue_start_$x' name='tue_start_$x' onChange='mainCall(name); checkTime(name);' class='schedule_table'>";
                        echo "<option value='def'>start</option>";
                        
                        $dayNo=7;
                        $sqlShiftSelect = 'select shift_id, start_time,end_time,
                        concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                        ":", substr(start_time, length(start_time)-1,length(start_time)), "-",
                        (substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),
                        ":", substr(end_time, length(end_time)-1,length(end_time))) as shift from subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['start_time']."_".$row['end_time'] . "' id='shift' name='shift' class='schedule_table'>" . $row['shift'] . "</option>";
                        }
                        
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        
                        echo "<select disabled id='tue_end_$x' name='tue_end_$x' onChange='endMainCall(name);' class='schedule_table_end'>";
                        echo "<option value='def'>end</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='630'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='730'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "<option value='830'>8:30</option>";
                        echo "<option value='900'>9:00</option>";
                        echo "<option value='930'>9:30</option>";
                        echo "<option value='1000'>10:00</option>";
                        echo "<option value='1030'>10:30</option>";
                        echo "<option value='1100'>11:00</option>";
                        echo "<option value='1130'>11:30</option>";
                        echo "<option value='1200'>12:00</option>";
                        echo "<option value='1230'>12:30</option>";
                        echo "<option value='1300'>1:00</option>";
                        echo "<option value='1330'>1:30</option>";
                        echo "<option value='1400'>2:00</option>";
                        echo "<option value='1430'>2:30</option>";
                        echo "<option value='1500'>3:00</option>";
                        echo "<option value='1530'>3:30</option>";
                        echo "<option value='1600'>4:00</option>";
                        echo "<option value='1630'>4:30</option>";
                        echo "<option value='1700'>5:00</option>";
                        echo "<option value='1730'>5:30</option>";
                        echo "<option value='1800'>6:00</option>";
                        echo "<option value='1830'>6:30</option>";
                        echo "<option value='1900'>7:00</option>";
                        echo "<option value='1930'>7:30</option>";
                        echo "<option value='2000'>8:00</option>";
                        echo "<option value='2030'>8:30</option>";
                        echo "<option value='2100'>9:00</option>";
                        echo "<option value='2130'>9:30</option>";
                        echo "<option value='2200'>10:00</option>";
                        echo "</select>";
                        echo "</tr>";
                         
                        
                       
                        echo "<input type='hidden' id='wed_time_start_$x' name='wed_time_start_$x' value=''>";
                        echo "<input type='hidden' id='wed_time_end_$x' name='wed_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='thu_time_start_$x' name='thu_time_start_$x' value=''>";
                        echo "<input type='hidden' id='thu_time_end_$x' name='thu_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='fri_time_start_$x' name='fri_time_start_$x' value=''>";
                        echo "<input type='hidden' id='fri_time_end_$x' name='fri_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='sat_time_start_$x' name='sat_time_start_$x' value=''>";
                        echo "<input type='hidden' id='sat_time_end_$x' name='sat_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='sun_time_start_$x' name='sun_time_start_$x' value=''>";
                        echo "<input type='hidden' id='sun_time_end_$x' name='sun_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='mon_time_start_$x' name='mon_time_start_$x' value=''>";
                        echo "<input type='hidden' id='mon_time_end_$x' name='mon_time_end_$x' value=''>";
                        
                        echo "<input type='hidden' id='tue_time_start_$x' name='tue_time_start_$x' value=''>";
                        echo "<input type='hidden' id='tue_time_end_$x' name='tue_time_end_$x' value=''>";
                     
       
                        echo "<input type='hidden' id='total_$x' name='total_$x' value=''>";
                    }
                    
                    echo "<input type='hidden' id='index' name='index' value='$x'>";
                   
                ?>
                        
                <tr><td colspan="9"><input type="submit" value="Create Schedule:"/></td></tr>  
                </form>
                </table>
         <div hidden id="requests" align="left">
             <p>Requests off this week:</p>
                <table id="request_table" class="schedule_table">
                <tr align=left>
                    <th>Name</th>
                     <th>Start Day</th>
                     <th>End Day</th>
                     <th>Start Time</th>
                     <th>End Time</th>
                </tr>
                <?php      
                    $sqlCommand = "SELECT E.first_name, E.last_name, R.start_date, R.end_date,
                        concat(substr(if(R.start_time>=1300, (R.start_time-1200), R.start_time),1,length(if(R.start_time>=1300, (R.start_time-1200), R.start_time))-2),concat(':',substr(start_time,length(start_time)-1,length(start_time)))) as start_time,
                        concat(substr(if(R.end_time>=1300, (R.end_time-1200), R.end_time),1,length(if(R.end_time>=1300, (R.end_time-1200), R.end_time))-2),concat(':',substr(end_time,length(end_time)-1,length(end_time)))) as end_time
                        FROM subway.request R, subway.employee E 
                        where /*(R.start_date between '2013-06-01' and '2013-06-07' OR R.end_date between '2013-06-01' and '2013-06-07')
                        and */R.employee_id = E.employee_id";
                    $result = mysqli_query($db_connect, $sqlCommand);

                    $reqCount=1;
                    while ($row = mysqli_fetch_array($result)){
                        //echo"<li><a><u>DATE:</u> $row[start_date] - $row[end_date] ---- <u>EMPLOYEE:</u> $row[first_name] $row[last_name] ---- <u>TIME:</u> $row[start_time]-$row[end_time] </a></li>";
                        echo"<tr><td hidden id='td_name_$reqCount'>$row[first_name] $row[last_name]</td>";
                        echo"<td hidden id='td_startdate_$reqCount'>$row[start_date]</td>";
                        echo"<td hidden id='td_enddate_$reqCount'>$row[end_date]</td>";
                        echo"<td hidden id='td_starttime_$reqCount'>$row[start_time]</td>";
                        echo"<td hidden id='td_endtime_$reqCount'>$row[end_time]</td>";
                        $reqCount++;
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

<script language="Javascript">
    
    function mainCall(table)
    {
        var name = table;
        resetTime(name);
        dayTimeCheck(name);
        weekHourTotal(name);
    }
    
    function endMainCall(table)
    {
        var name = table; 
        resetTime(name);
        dayTimeCheck(name);
        weekHourTotal(name);
    }
    
    function resetTime(table)
    {    
        var table_name = table.split("_");
        
        var start_name = table_name[0]+"_start_"+table_name[2];
        var end_name = table_name[0]+"_end_"+table_name[2];
        var shift_time_name = table_name[0] + "_time_start_" + table_name[2];
        
        var table_one = document.getElementById(start_name);
        var table_two = document.getElementById(end_name);
        
        if(table_one.value.length > 6)
        {
            document.getElementById(end_name).value="def";
            document.getElementById(shift_time_name).value = document.getElementById(start_name).value;
        }
        else
        {
            checkTime(table);
        }
    }
    
    /*
     * checkTime will grab the value for minumum shift time and set 
     * the end time to that minimum. If a start time was selected that 
     * does not allow for the minimum shift time the user is alerted. 
     * 
     * 
     * 
     * If time, we should probably have the start list end at what would be
     * the minium time. 
     */
    function checkTime(table)
    {    
        var table_name = table.split("_");
        
        var start_name = table_name[0]+"_start_"+table_name[2];
        var end_name = table_name[0]+"_end_"+table_name[2];
        
        var table_one = document.getElementById(start_name);
        var table_two = document.getElementById(end_name);
        
        var min_shift_hours = document.getElementById('min_shift_hours').value; 
        
        //If the start row was clicked, set end time ahead by number of shifts 
        //that are the minimum. 
        if(table_name[1] == "start")
        {
            for(var x = 0; x < table_one.length; x++)
            {
                if(table_one.value == table_two[x].value)
                {
                    var found_index = x;
                    //alert(table_two.length - (min_shift_hours *2));
                    break;
                }   
            }
            
            if((found_index < table_two.length - (min_shift_hours * 2)))
            {
                var auto_index = found_index + (min_shift_hours * 2);
                table_two.value = table_two[auto_index].value;
            }
            if(found_index > table_two.length - (min_shift_hours * 2))
            {
                alert("Minimum Shift Time Is " + min_shift_hours);
                table_one.value = 'def';
                table_two.value = table_two[0].value;       
            }
        }
        else
        { 
            //Loop through the second table. 
            for(x=0;x<table_two.length;x++)
            {    
                //Location in table two that matches the start time. 
                if(table_two[x].value == table_one.value)
                    var first_value = x; 
                //Location in table two that matches the end time. 
                if(table_two[x].value == table_two.value)
                    var second_value = x; 
            }
            
            if((second_value - first_value) < (min_shift_hours * 2))
            {    
                var spots_to_move = (min_shift_hours * 2)-(second_value - first_value);
                
                table_one[x].value = "def";
                table_two[x].value = "def";
            }
        }
    }
    
    /*
     *weekHourTotal will keep a tally of the total hours each employee
     *is scheduled for a week. If the total goes over the allotted time for a 
     *certain employee type their total is changed to red font. If it goes 
     *back under it will switch back to black.  
     */
    function weekHourTotal(table)
    {   
        var table_name = table.split("_");
        var index = table_name[2];
        
        var start_name = table_name[0]+"_start_"+table_name[2];
        var end_name = table_name[0]+"_end_"+table_name[2];
        
        var table_one = document.getElementById(start_name);
        var table_two = document.getElementById(end_name);
        
        var type = "type_"+index;
        var employee_type = document.getElementById(type).value;
            
        //Only executes when both start and end times are not default
        //otherwise NaN will show up in the hour total column. 
        if(table_one.value != "def" )
        {
            var max_full = document.getElementById("max_week_full").value;
            var max_part = document.getElementById("max_week_part").value;
            
            var wed_start = document.getElementById("wed_time_start_"+index).value;
            var wed_end = document.getElementById("wed_time_end_"+index).value;
            
            var thu_start = document.getElementById("thu_time_start_"+index).value;
            var thu_end = document.getElementById("thu_time_end_"+index).value;
            
            var fri_start = document.getElementById("fri_time_start_"+index).value;
            var fri_end = document.getElementById("fri_time_end_"+index).value;
            
            var sat_start = document.getElementById("sat_time_start_"+index).value;
            var sat_end = document.getElementById("sat_time_end_"+index).value;
            
            var sun_start = document.getElementById("sun_time_start_"+index).value;
            var sun_end = document.getElementById("sun_time_end_"+index).value;
            
            var mon_start = document.getElementById("mon_time_start_"+index).value;
            var mon_end = document.getElementById("mon_time_end_"+index).value;
            
            var tue_start = document.getElementById("tue_time_start_"+index).value;
            var tue_end = document.getElementById("tue_time_end_"+index).value;
            
            if(mon_start.substring(mon_start.length-2)== 30){
                var work_pls = mon_start.substring(0,mon_start.length-2) + 50;
                mon_start = work_pls;   
            }
            if(mon_end.substring(mon_end.length-2)==30){
                var work_pls = mon_end.substring(0,mon_end.length-2) + 50;
                mon_end = work_pls;
            }
            
            if(tue_start.substring(tue_start.length-2)== 30){
                var work_pls = tue_start.substring(0,tue_start.length-2) + 50;
                tue_start = work_pls;   
            }  
            if(tue_end.substring(tue_end.length-2)==30){
                var work_pls = tue_end.substring(0,tue_end.length-2) + 50;
                tue_end = work_pls;
            }
            
            if(wed_start.substring(wed_start.length-2)== 30){
                var work_pls = wed_start.substring(0,wed_start.length-2) + 50;
                wed_start = work_pls;   
            }
            if(wed_end.substring(wed_end.length-2)==30){
                var work_pls = wed_end.substring(0,wed_end.length-2) + 50;
                wed_end = work_pls;
            }
            
            if(thu_start.substring(thu_start.length-2)== 30){
                var work_pls = thu_start.substring(0,thu_start.length-2) + 50;
                thu_start = work_pls;   
            }
            
            if(thu_end.substring(thu_end.length-2)==30){
                var work_pls = thu_end.substring(0,thu_end.length-2) + 50;
                thu_end = work_pls;
            }
            
            if(fri_start.substring(fri_start.length-2)== 30){
                var work_pls = fri_start.substring(0,fri_start.length-2) + 50;
                fri_start = work_pls;   
            }
            if(fri_end.substring(fri_end.length-2)==30){
                var work_pls = fri_end.substring(0,fri_end.length-2) + 50;
                fri_end = work_pls;
            }
            
            if(sat_start.substring(sat_start.length-2)== 30){
                var work_pls = sat_start.substring(0,sat_start.length-2) + 50;
                sat_start = work_pls;   
            }
            if(sat_end.substring(sat_end.length-2)==30){
                var work_pls = sat_end.substring(0,sat_end.length-2) + 50;
                sat_end = work_pls;
            }
            
            if(sun_start.substring(sun_start.length-2)== 30){
                var work_pls = sun_start.substring(0,sun_start.length-2) + 50;
                sun_start = work_pls;   
            }
            if(sun_end.substring(sun_end.length-2)==30){
                var work_pls = sun_end.substring(0,sun_end.length-2) + 50;
                sun_end = work_pls;
            }
            
            var wed_hours = Number(wed_end) - Number(wed_start);
            var thu_hours = Number(thu_end) - Number(thu_start);
            var fri_hours = Number(fri_end) - Number(fri_start);
            var sat_hours = Number(sat_end) - Number(sat_start);
            var sun_hours = Number(sun_end) - Number(sun_start);
            var mon_hours = Number(mon_end) - Number(mon_start);
            var tue_hours = Number(tue_end) - Number(tue_start);
            
            var total_hours = (wed_hours + thu_hours + fri_hours + sat_hours + sun_hours + mon_hours + tue_hours)/100;
            document.getElementById("hour_total_"+index).value = total_hours.toFixed(2);
            document.getElementById("total_"+index).value = total_hours.toFixed(2);
            
            if(employee_type == "F" || employee_type == "M")
            {
                if(Number(total_hours) > Number(max_full))
                {
                    document.getElementById("hour_total_"+index).style.color = 'red';
                }
                else
                {
                    document.getElementById("hour_total_"+index).style.color = 'black';
                }
                
            }
            else
            {
                if(Number(total_hours) > Number(max_part))
                {
                    document.getElementById("hour_total_"+index).style.color = 'red';
                }
                else
                {
                    document.getElementById("hour_total_"+index).style.color = 'black';
                }
            }
        }
    }
    
    /*
     * dayTimeCheck will verify that the length of the shift fits in 
     * the maximum time for part time and full time employees and 
     * put the user selected hours into the hidden input fields.  
     * 
     * 
     * Doesn't work for shifts, so if time...
     */
    function dayTimeCheck(table){
        
        var max_day_part = document.getElementById('max_day_part').value;
        var max_day_full = document.getElementById('max_day_full').value;
        
        var table_name = table.split("_");
        
        var start_name = table_name[0]+"_start_"+table_name[2];
        var end_name = table_name[0]+"_end_"+table_name[2];
        
        var start_time = document.getElementById(start_name).value;
        var end_time = document.getElementById(end_name).value;
        
        var index = table_name[2];
        var day = table_name[0];
        
        var type = "type_"+index;
        var emp_type = document.getElementById(type).value;
        
        
        var isMinor = document.getElementById("minor_"+index).value;
        
        //if the employee is full-time
        if(emp_type == "F" || emp_type == "M")
        {
            if(end_time != "def")
            {       
                if((end_time - start_time) > (max_day_full * 100))
                {      
                    alert("Over Maximum Full-Time Daily Hours");
                }//end if for over full-time day
                switch(day)
                {
                    case "wed":
                        document.getElementById("wed_time_start_"+index).value = start_time;
                        document.getElementById("wed_time_end_"+index).value = end_time;
                        break;
                    case "thu":
                        document.getElementById("thu_time_start_"+index).value = start_time;
                        document.getElementById("thu_time_end_"+index).value=end_time;
                        break;
                    case "fri":
                        document.getElementById("fri_time_start_"+index).value = start_time;
                        document.getElementById("fri_time_end_"+index).value = end_time;
                        break;
                    case "sat":
                        document.getElementById("sat_time_start_"+index).value = start_time;
                        document.getElementById("sat_time_end_"+index).value = end_time;
                        break;
                    case "sun":
                        document.getElementById("sun_time_start_"+index).value = start_time;
                        document.getElementById("sun_time_end_"+index).value = end_time;
                        break;
                    case "mon":
                        document.getElementById("mon_time_start_"+index).value = start_time;
                        document.getElementById("mon_time_end_"+index).value = end_time;
                        break;
                    case "tue":
                        document.getElementById("tue_time_start_"+index).value = start_time;
                        document.getElementById("tue_time_end_"+index).value = end_time;
                        break;
                }//end switch 
            }
            else
            {   
                var shift_split = start_time.split("_");
                var shift_start = shift_split[0];
                var shift_end = shift_split[1];
                
                if((shift_end - shift_start) > (max_day_full * 100))
                {       
                    alert("Over Maximum Full-Time Daily Hours"); 
                }
                
                switch(day)
                {       
                    case "wed":
                        document.getElementById("wed_time_start_"+index).value = shift_start;
                        document.getElementById("wed_time_end_"+index).value = shift_end;
                        break;
                    case "thu":
                        document.getElementById("thu_time_start_"+index).value = shift_start;
                        document.getElementById("thu_time_end_"+index).value = shift_end;
                        break;
                    case "fri":
                        document.getElementById("fri_time_start_"+index).value = shift_start;
                        document.getElementById("fri_time_end_"+index).value = shift_end;
                        break;
                    case "sat":
                        document.getElementById("sat_time_start_"+index).value = shift_start;
                        document.getElementById("sat_time_end_"+index).value = shift_end;
                        break;
                    case "sun":
                        document.getElementById("sun_time_start_"+index).value = shift_start;
                        document.getElementById("sun_time_end_"+index).value = shift_end;
                        break;
                    case "mon":
                        document.getElementById("mon_time_start_"+index).value = shift_start;
                        document.getElementById("mon_time_end_"+index).value = shift_end;
                        break;
                    case "tue":
                        document.getElementById("tue_time_start_"+index).value = shift_start;
                        document.getElementById("tue_time_end_"+index).value = shift_end;
                        break;
                }
            }
        }
        else
        {
            if(end_time != "def")
            {   
                if((end_time - start_time >= 600) && isMinor == "Y")
                {
                    switch(day)
                    {    
                        case "wed":
                            document.getElementById("wed_"+index).style.backgroundColor = 'red';
                            break;
                        case "thu":
                            document.getElementById("thu_"+index).style.backgroundColor = 'red';
                            break;
                        case "fri":
                            document.getElementById("fri_"+index).style.backgroundColor = 'red';
                            break;
                        case "sat":
                            document.getElementById("sat_"+index).style.backgroundColor = 'red';
                            break;
                        case "sun":
                            document.getElementById("sun_"+index).style.backgroundColor = 'red';
                            break;
                        case "mon":
                            document.getElementById("mon_"+index).style.backgroundColor = 'red';
                            break;
                        case "tue":
                            document.getElementById("tue_"+index).style.backgroundColor = 'red';
                            break;
                    }         
                }
                else
                {
                    switch(day)
                    {
                        case "wed":
                            document.getElementById("wed_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "thu":
                            document.getElementById("thu_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "fri":
                            document.getElementById("fri_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "sat":
                            document.getElementById("sat_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "sun":
                            document.getElementById("sun_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "mon":
                            document.getElementById("mon_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "tue":
                            document.getElementById("tue_"+index).style.backgroundColor = 'lightgreen';
                            break;
                    }//end switch
                }//end else
                
                if((end_time - start_time) > (max_day_part *100))
                {
                    alert("Over Maximum Part-Time Daily Hours:");    
                }
                
                switch(day)
                {   
                    case "wed":
                        document.getElementById("wed_time_start_"+index).value = start_time;
                        document.getElementById("wed_time_end_"+index).value = end_time;
                        break;
                    case "thu":
                        document.getElementById("thu_time_start_"+index).value = start_time;
                        document.getElementById("thu_time_end_"+index).value=end_time;
                        break;
                    case "fri":
                        document.getElementById("fri_time_start_"+index).value = start_time;
                        document.getElementById("fri_time_end_"+index).value = end_time;
                        break;
                    case "sat":
                        document.getElementById("sat_time_start_"+index).value = start_time;
                        document.getElementById("sat_time_end_"+index).value = end_time;
                        break;
                    case "sun":
                        document.getElementById("sun_time_start_"+index).value = start_time;
                        document.getElementById("sun_time_end_"+index).value = end_time;
                        break;
                    case "mon":
                        document.getElementById("mon_time_start_"+index).value = start_time;
                        document.getElementById("mon_time_end_"+index).value = end_time;
                        break;
                    case "tue":
                        document.getElementById("tue_time_start_"+index).value = start_time;
                        document.getElementById("tue_time_end_"+index).value = end_time;
                        break;
                }                       
            }
            else
            {
                var shift_split = start_time.split("_");
                var shift_start = shift_split[0];
                var shift_end = shift_split[1];
                
                if((shift_end - shift_start >= 600) && isMinor == "Y")
                {
                    switch(day)
                    {    
                        case "wed":
                            document.getElementById("wed_"+index).style.backgroundColor = 'red';
                            break;
                        case "thu":
                            document.getElementById("thu_"+index).style.backgroundColor = 'red';
                            break;
                        case "fri":
                            document.getElementById("fri_"+index).style.backgroundColor = 'red';
                            break;
                        case "sat":
                            document.getElementById("sat_"+index).style.backgroundColor = 'red';
                            break;
                        case "sun":
                            document.getElementById("sun_"+index).style.backgroundColor = 'red';
                            break;
                        case "mon":
                            document.getElementById("mon_"+index).style.backgroundColor = 'red';
                            break;
                        case "tue":
                            document.getElementById("tue_"+index).style.backgroundColor = 'red';
                            break;
                    }         
                }
                else
                {
                    switch(day)
                    {
                        case "wed":
                            document.getElementById("wed_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "thu":
                            document.getElementById("thu_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "fri":
                            document.getElementById("fri_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "sat":
                            document.getElementById("sat_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "sun":
                            document.getElementById("sun_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "mon":
                            document.getElementById("mon_"+index).style.backgroundColor = 'lightgreen';
                            break;
                        case "tue":
                            document.getElementById("tue_"+index).style.backgroundColor = 'lightgreen';
                            break;
                    }//end switch
                }
                
                //If the shift was over the max hours for a full-time day
                if((shift_end - shift_start) > (max_day_part * 100))
                {
                    alert("Over Maximum Part-Time Daily Hours");
                }
                
                switch(day)
                {    
                    case "wed":
                        document.getElementById("wed_time_start_"+index).value = shift_start;
                        document.getElementById("wed_time_end_"+index).value = shift_end;
                        break;
                    case "thu":
                        document.getElementById("thu_time_start_"+index).value = shift_start;
                        document.getElementById("thu_time_end_"+index).value = shift_end;
                        break;
                    case "fri":
                        document.getElementById("fri_time_start_"+index).value = shift_start;
                        document.getElementById("fri_time_end_"+index).value = shift_end;
                        break;
                    case "sat":
                        document.getElementById("sat_time_start_"+index).value = shift_start;
                        document.getElementById("sat_time_end_"+index).value = shift_end;
                        break;
                    case "sun":
                        document.getElementById("sun_time_start_"+index).value = shift_start;
                        document.getElementById("sun_time_end_"+index).value = shift_end;
                        break;
                    case "mon":
                        document.getElementById("mon_time_start_"+index).value = shift_start;
                        document.getElementById("mon_time_end_"+index).value = shift_end;
                        break;
                    case "tue":
                        document.getElementById("tue_time_start_"+index).value = shift_start;
                        document.getElementById("tue_time_end_"+index).value = shift_end;
                        break;
                }
            }
        }
    }
    
    function enableMonth()
    {
        document.getElementById("month_sched").disabled = false;
    }
    
    function setDaysInMonth(){
        // sets day count in HTML select option list for selected month
        var selectedYear = document.getElementById("year_sched").value;
        var selectedMonth = document.getElementById("month_sched").value;
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        
        // loop through list of days in month and populate the option list
        for(d=1;d<=daysInMonth;d++){
            var x=document.getElementById("day_sched");
            var option=document.createElement("option");
            var myDate = new Date(selectedYear, selectedMonth-1, d);
            //only display Wednesdays:
            if(myDate.getDay() == 3)
            {
                option.text=d;
                try
                {
                    x.add(option,x.options[null]);
                }
                catch (e)
                {
                    x.add(option,null);
                }
            }
        }
        //enable day selector field
        document.getElementById("day_sched").disabled = false;
    }
    
    function displaySchedDays(table){
        // displays day and month value on the schedule
        var start_day = document.getElementById("day_sched").value;
        var selectedYear = document.getElementById("year_sched").value;
        var selectedMonth = document.getElementById("month_sched").value;
        var daysInMonth = new Date(selectedYear, selectedMonth, 0).getDate();
        
        // month array to translate month number to month name
        var month=new Array();
        month[1]="Jan";
        month[2]="Feb";
        month[3]="Mar";
        month[4]="Apr";
        month[5]="May";
        month[6]="Jun";
        month[7]="Jul";
        month[8]="Aug";
        month[9]="Sep";
        month[10]="Oct";
        month[11]="Nov";
        month[12]="Dec";
        var monthNameNow = month[selectedMonth];
        if (selectedMonth===12){
            selectedMonth=0;
        }
        var monthNameNext = month[++selectedMonth];
        
        // output the values: Wed, Jun 8
        for(index=1;index<8;index++)
        {
            switch(index)
            {
                case(1): 
                        var test = "Wed";
                        document.getElementById("day_num"+index).innerHTML = test + ", " + monthNameNow + " " + start_day;
                        break;
                case(2):
                        var test = "Thu";
                        document.getElementById("day_num"+index).innerHTML = test + ", " + monthNameNow + " " + start_day;
                        break;
                case(3):
                       var test = "Fri";
                       document.getElementById("day_num"+index).innerHTML = test + ", " + monthNameNow + " " + start_day;
                       break;
                case(4):
                       var test = "Sat";
                       document.getElementById("day_num"+index).innerHTML = test + ", " + monthNameNow + " " + start_day;
                       break;
                case(5):
                       var test = "Sun";
                       document.getElementById("day_num"+index).innerHTML = test + ", " + monthNameNow + " " + start_day;
                       break;
                case(6):
                       var test = "Mon";
                       document.getElementById("day_num"+index).innerHTML = test + ", " + monthNameNow + " " + start_day;
                       break;
                 case(7):
                        var test = "Tue";
                        document.getElementById("day_num"+index).innerHTML = test + ", " + monthNameNow + " " + start_day;
                        break;
            }
            
            if(start_day==daysInMonth)
            {
                //new month
                start_day=1;
                monthNameNow=monthNameNext;
            }
            else
            {
                //same month
                start_day++;
            }
        }
        
        // This section sets the requests values in the request table
        var setDay = document.getElementById("day_sched").value;
        var setYear = document.getElementById("year_sched").value;
        var setMonth = document.getElementById("month_sched").value-1;
        var schedStartDate = new Date(setYear, setMonth, setDay);
        var schedEndDate = new Date(setYear, setMonth, +setDay+6);
        
        document.getElementById("requests").hidden=false;
        
        var req_table = document.getElementById("request_table");
        for (var i = 0, row; row = req_table.rows[i]; i++) {
           for (var j = 0, col; col = row.cells[j]; j++) {
             if (i>0 && (j==1 || j==2)){
                if (j==1){//start date
                        var startSplit = (col.innerHTML).split("-");
                        var reqStartYear = startSplit[0];
                        var reqStartMonth = startSplit[1]-1;
                        var reqStartDay = startSplit[2];
                }
                if (j==2){//end date
                        var endSplit = (col.innerHTML).split("-");
                        var reqEndYear = endSplit[0];
                        var reqEndMonth = endSplit[1]-1;
                        var reqEndDay = endSplit[2];
                }
                
                
                var reqStartDate = new Date(reqStartYear, reqStartMonth, reqStartDay);
                var reqEndDate = new Date(reqEndYear, reqEndMonth, reqEndDay);
             }
             if(i>0 && (j==3)){
                 if((reqStartDate >= schedStartDate && reqStartDate <= schedEndDate) || (reqEndDate >= schedStartDate && reqEndDate <= schedEndDate) || (reqStartDate <= schedStartDate && reqEndDate >= schedEndDate)) {
                    document.getElementById("td_name_"+i).style.display = 'block'; 
                    document.getElementById("td_startdate_"+i).style.display = 'block'; 
                    document.getElementById("td_enddate_"+i).style.display = 'block'; 
                    document.getElementById("td_starttime_"+i).style.display = 'block'; 
                    document.getElementById("td_endtime_"+i).style.display = 'block'; 
                 }
             }
           }  
        }
        document.getElementById("requests").style.display = 'block'; 
        
        // enable the schedule grid:
        for(index=0;index<=table; index++){
            document.getElementById("wed_start_"+index).disabled = false;
            document.getElementById("wed_end_"+index).disabled = false;
            document.getElementById("thu_start_"+index).disabled = false;
            document.getElementById("thu_end_"+index).disabled = false;
            document.getElementById("fri_start_"+index).disabled = false;
            document.getElementById("fri_end_"+index).disabled = false;
            document.getElementById("sat_start_"+index).disabled = false;
            document.getElementById("sat_end_"+index).disabled = false;
            document.getElementById("sun_start_"+index).disabled = false;
            document.getElementById("sun_end_"+index).disabled = false;            
            document.getElementById("mon_start_"+index).disabled = false;
            document.getElementById("mon_end_"+index).disabled = false;
            document.getElementById("tue_start_"+index).disabled = false;
            document.getElementById("tue_end_"+index).disabled = false;
        }
    }
    
    function resetDaySelector(table){
        // reset all day selector fields as well as the day value on schedule
        var req_table = document.getElementById("request_table");
        for (var i = 1, row; row = req_table.rows[i]; i++) {
            for (var j = 0, col; col = row.cells[j]; j++) {
                document.getElementById("td_name_"+i).style.display = 'none';
                document.getElementById("td_startdate_"+i).style.display = 'none';
                document.getElementById("td_enddate_"+i).style.display = 'none';
                document.getElementById("td_starttime_"+i).style.display = 'none';
                document.getElementById("td_endtime_"+i).style.display = 'none';
            }
        }
        document.getElementById("month_sched").disabled = true;
        document.getElementById("day_sched").disabled = true;
        document.getElementById("day_sched").options.length = 1;
        document.getElementById("year_sched").value = "default";
        document.getElementById("month_sched").value="default";
        document.getElementById("day_sched").value = "default";
        document.getElementById("day_num1").innerHTML = "Wed";
        document.getElementById("day_num2").innerHTML = "Thu";
        document.getElementById("day_num3").innerHTML = "Fri";
        document.getElementById("day_num4").innerHTML = "Sat";
        document.getElementById("day_num5").innerHTML = "Sun";
        document.getElementById("day_num6").innerHTML = "Mon";
        document.getElementById("day_num7").innerHTML = "Tue";
        
        for(index=0;index<=table; index++){
            document.getElementById("wed_start_"+index).disabled = true;
            document.getElementById("wed_end_"+index).disabled = true;
            document.getElementById("thu_start_"+index).disabled = true;
            document.getElementById("thu_end_"+index).disabled = true;
            document.getElementById("fri_start_"+index).disabled = true;
            document.getElementById("fri_end_"+index).disabled = true;
            document.getElementById("sat_start_"+index).disabled = true;
            document.getElementById("sat_end_"+index).disabled = true;
            document.getElementById("sun_start_"+index).disabled = true;
            document.getElementById("sun_end_"+index).disabled = true;            
            document.getElementById("mon_start_"+index).disabled = true;
            document.getElementById("mon_end_"+index).disabled = true;
            document.getElementById("tue_start_"+index).disabled = true;
            document.getElementById("tue_end_"+index).disabled = true;            
        }
    }
</script>
