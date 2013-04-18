<?php
session_start();

if($_SESSION['current_prod'] != true){
    header("Location: productivity.php");
}

include_once '../../Subway/HelperFiles/config.php';
include_once '../../Subway/HelperFiles/employeeClass.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';
include_once '../../Subway/HelperFiles/shiftClass.php';

$sqlCommand = "SELECT employee_id, first_name, last_name from subway.employee";

$result = mysqli_query($db_connect, $sqlCommand);

$schedule_array = array();

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

        <div id="page_top">
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
                
                <form action="/HelperFiles/getSchedule.php" method="POST">
                
                    <table class="schedule_table">
                 
                        <tr>
                            <th id="table_title" colspan="15">Create New Schedule:</th>
                        </tr>
               
                        <tr>
                            <th>Employee:</th>
                            <th>Wednesday:</th>
                            <th>Thursday:</th>
                            <th>Friday:</th>
                            <th>Saturday:</th>
                            <th>Sunday:</th>
                            <th>Monday:</th>
                            <th>Tuesday:</th>
                        </tr>             
                <?php
                    
                    $array = array(1,2,3,4,5,6,7);
                
                    for($x=0;$x<count($_SESSION['schedule_array']);$x++){
                        echo "<input type='hidden' id='test'>";
                        echo "<tr><td class='sched_emp'>";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeFirstName()." ";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeLastName()."</td>";
                        
                        $wed_start_name = "wed_start_".$x;
                        $wed_end_name = "wed_end_".$x;
                        
                        $thurs_start_name="thu_start_".$x;
                        $thurs_end_name ="thu_end_".$x;
                        
                        $fri_start_name = "fri_start_".$x;
                        $fri_end_name = "fri_end_".$x;
                        
                        $sat_start_name = "sat_start_".$x;
                        $sat_end_name = "sat_end_".$x;
                        
                        $sun_start_name = "sun_start_".$x;
                        $sun_end_name = "sun_end_".$x;
                        
                        $mon_start_name = "mon_start_".$x;
                        $mon_end_name = "mon_end_".$x;
                        
                        $tues_start_name = "tue_start_".$x;
                        $tues_end_name = "tue_end_".$x;
                        
                        echo "<td><select id=\"$wed_start_name\" name='wed_start' onChange='resetTime(\"$wed_start_name\");'>";
                        echo "<option value='default'>start</option>";
                        
                        $dayNo=1;
                        $sqlShiftSelect = 'select shift_id, concat(substr(if(start_time>=1300, (start_time-1200), start_time),1,length(if(start_time>=1300, (start_time-1200), start_time))-2),
                            ":00-",(substr(if(end_time>=1300, (end_time-1200), end_time),1,length(if(end_time>=1300, (end_time-1200), end_time))-2)),":00")as shift
                            From subway.shifts where day='.$dayNo.'';
                        $result = mysqli_query($db_connect, $sqlShiftSelect);
                        while ($row = mysqli_fetch_array($result)) {
                           echo "<option value='" . $row['shift'] . "' id='shift' name='shift'>" . $row['shift'] . "</option>";
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
                        
                        echo "<select id=\"$wed_end_name\" name='wed_end' onChange='resetTime(\"$wed_end_name\");'>";
                        
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
                        
                        
                        echo "<td><select id=\"$thurs_start_name\" name='thu_start' onChange='resetTime(\"$thurs_start_name\");'>";
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
                        
                        echo "<select id=\"$thurs_end_name\" name='thu_end' onChange='resetTime(\"$thurs_end_name\");'>";
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
                        
                        echo "<td><select id=\"$fri_start_name\" name='fri_start' onChange='resetTime(\"$fri_start_name\");'>";
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
                        
                        echo "<select id=\"$fri_end_name\" name='fri_end' onChange='resetTime(\"$fri_end_name\");'>";
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
                        
                        echo "<td><select id=\"$sat_start_name\" name='sat_start' onChange='resetTime(\"$sat_start_name\");'>";
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
                        
                        echo "<select id=\"$sat_end_name\" name='sat_end' onChange='resetTime(\"$sat_end_name\");'>";
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
                        
                        
                        echo "<td><select id=\"$sun_start_name\" name='sun_start' onChange='resetTime(\"$sun_start_name\");'>";
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
                        
                        echo "<select id=\"$sun_end_name\" name='sun_end' onChange='resetTime(\"$sun_end_name\");'>";
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
                        
                        echo "<td><select id=\"$mon_start_name\" name='mon_start' onChange='resetTime(\"$mon_start_name\");'>";
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
                        
                        echo "<select id=\"$mon_end_name\" name='mon_end' onChange='resetTime(\"$mon_end_name\");'>";
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
                        
                       
                        echo "<td><select id=\"$tues_start_name\" name='tue_start' onChange='resetTime(\"$tues_start_name\");'>";
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
                        
                        echo "<select id=\"$tues_end_name\" name='tue_end' onChange='resetTime(\"$tues_end_name\");'>";
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
                    }
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

    function selectTime(){
        
       for(var x = 0; x < blah.length;x++){
           
        alert(blah[x]);
        
       }
        
       document.getElementById('wed_shift').value="default";
    }

    function selectShift(){
        
        
        document.getElementById('wed_start').value="default";
        
    }
    
   function resetTime(table){
       
       var table_name = table.split("_");
       var alt_name = table_name[0]+"_end_"+table_name[2];
       
       var selection = document.getElementById(table).value;
       
       // Resets the shift field if the start or end times are selected and 
       // vise versa if shift is selected:
        //if(table.substring(table.length-5,table.length) === "shift"){
        if(selection.length > 5){
            //document.getElementById(table.substring(0,3) + '_start').value="default";
            document.getElementById(alt_name).value="default";
        }
        else
        {
            document.getElementById(table.substring(0,3) + '_shift').value="default";
        }
   }
</script>
    
