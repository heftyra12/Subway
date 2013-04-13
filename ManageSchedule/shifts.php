<?php

session_start();

include_once'../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/shiftsClass.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

$shift_array = array();

$sqlCommand = "SELECT shift_id, day, start_time, end_time FROM subway.shifts";
$result = mysqli_query($db_connect, $sqlCommand);

while ($row = mysqli_fetch_array($result)) {

    $shift = new shiftsClass($row["shift_id"],$row["day"],$row["start_time"],$row["end_time"]);
    array_push($shift_array, $shift);
}
$_SESSION['shift_array']=$shift_array;
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
            <form  action="productivity.php" method="POST">
                <input type="submit" value="Enter Productivity" class="subway_buttons"/>
            </form>
                <br/>
                <br/>
            <form action="index.php" method="POST">
                <input type="submit" value="Create Schedule" class="subway_buttons"/>
            </form>
            </div>
        </div>

        <div id="normal_right">
            
            <div id="shift_edit">
            
            <table>
                <form action="/HelperFiles/validateShifts.php" method="POST">
                <tr><th id="table_title" colspan="3">Edit Shifts</th></tr>
                <tr>
                    <td>Shift Day:</td>
                    <td><select id="shift_day" name="shift_day">
                            <option value="1">Wednesday</option>
                            <option value="2">Thursday</option>
                            <option value="3">Friday</option>
                            <option value="4">Saturday</option>
                            <option value="5">Sunday</option>
                            <option value="6">Monday</option>
                            <option value="7">Tuesday</optoin></td>
                </tr>
                <tr>
                    <td>Start Time:</td>
                    <td><input type="text" id="start_time" name="start_time"></td>
                </tr>
                <tr>
                    <td>End Time:</td>
                    <td><input type="text" id="end_time" name="end_time"></td>
                </tr>
                <tr>
                    <td>Action:</td>
                    <td><select id="update_choice" name="update_choice">
                            <option value="update">Update</option>
                            <option value="add">Add</option>
                            <option value="delete">Delete</option>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="3" ><input type="submit" value="Submit Shift"></td>
                    <input type="hidden" id="current_id" name="current_id">
                </tr>
                </form>
            </table>
            
            </div>
            <div id="shift_current">
            
            <table>
                
                <tr>
                    <th id="table_title" colspan="5">Shift Schedules</th>
                </tr>
                <tr>
                    <td></td>
                    <th>Day</th>
                    <th>Start Time:</th>
                    <th>End Time:</th>
                </tr>
                
                <?php
                
                
                for($x=0;$x<count($shift_array);$x++){
     
                    $day = $shift_array[$x]->getShiftDay();
                    $start_time = $shift_array[$x]->getStartTime();
                    $end_time = $shift_array[$x]->getEndTime();
                    $id = $shift_array[$x]->getShiftID();
                    
                    $day_array = array("Wednesday","Thursday","Friday","Saturday","Sunday","Monday","Tuesday");
                    
                    echo "<tr><td>";
                    echo "<input type='radio' id='shift' name='shift' onclick='insertShift(\"$day\",\"$start_time\",\"$end_time\",\"$id\");'></td>";
                    echo "<td>";
                    echo $day_array[$day - 1];
                    echo "<td>";
                    echo $shift_array[$x]->getStartTime();
                    echo "</td><td>";
                    echo $shift_array[$x]->getEndTime();
                    echo "</td></tr>";
                }
     
                ?>
                    
            </table>
            </div>
        </div>
    </div>
</body>
</html>

<script language ="Javascript">

    function insertShift(day,start_time,end_time,id){
        
        var day = day;
        var start_time = start_time;
        var end_time = end_time;
        var id = id; 
       
        document.getElementById("shift_day").value = day;
        document.getElementById("start_time").value = start_time;
        document.getElementById("end_time").value = end_time; 
        document.getElementById("current_id").value = id;
    }


</script>