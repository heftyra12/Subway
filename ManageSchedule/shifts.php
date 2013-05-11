<?php

session_start();

if(!isset($_SESSION['user_name']))
{
    header("Location: ../index.php");
}

include_once'../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/shiftsClass.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

$shift_array = array();

$sqlCommand = "SELECT shift_id, day, start_time, end_time FROM subway.shifts order by day, start_time asc";
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
        <link rel="shortcut icon" href="../images/subway.ico">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <script type="text/javascript" src="/HelperFiles/JS/setTime.js"></script>

        <title></title>
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
<!--            <form  action="productivity.php" method="POST">
                <input type="submit" value="Enter Productivity" class="subway_buttons"/>
            </form>
                <br/>
                <br/>-->
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
                    <td><select id="shift_start" name="shift_start" onChange="startTime('shift_start');" class="default_time_drop_down">
                               <option value="default">Start</option>
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
                           </select></td>
                </tr>
                <tr>
                    <td>End Time:</td>
                    <td><select name="shift_end" id="shift_end" class="default_time_drop_down" title="Select Start Time First:"><select></td>
                </tr>
                <tr>
                    <td>Action:</td>
                    <td><select id="update_choice" name="update_choice">
                            <option value="add">Add</option>
                            <option value="update">Update</option>
                            <option value="delete">Delete</option>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="button" value="Reset" onclick="formReset();"></trd>
                </tr>
                    <tr><td colspan="3" ><input type="submit" value="Submit Shift"></td>
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
                    $day_array = array("Wednesday","Thursday","Friday","Saturday","Sunday","Monday","Tuesday");
                    $day = $_SESSION['shift_array'][$x]->getShiftDay();
                    
                    $start_time = $shift_array[$x]->getStartTime();
                    $end_time = $shift_array[$x]->getEndTime();
                    $id = $shift_array[$x]->getShiftID();
                    
                    echo "<tr><td>";
                    echo "<input type='radio' id='shifts' name='shifts' onclick='insertShift(\"$day\",\"$start_time\",\"$end_time\",\"$id\");'></td>";
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

    function formReset(){
        
        var list = document.getElementsByName('shifts');
       
        for(var x =0; x < list.length; x++){    
            if(list[x].checked == true)
                list[x].checked = false; 
        }
     
        document.getElementById("shift_day").value = "1";
        document.getElementById("shift_start").value = "default";
        document.getElementById("shift_end").title="Select Start Time First:";
        document.getElementById("shift_end").options.length=0;
            
       var update_options = document.getElementById("update_choice");
       update_options.length = 0; 
   
       var option = document.createElement("Option");
       option.text = "Add";
       option.value = "add";
       
       var option_one = document.createElement("Option");
       option_one.text="Update";
       option_one.value="update";
        
       var option_two = document.createElement("Option");
       option_two.text="Delete";
       option_two.value="delete";
  
       update_options.options[0]=option;
       update_options.options[1]=option_one;
       update_options.options[2]=option_two;
       
    }

    function insertShift(day,start_time,end_time,id){
           
        document.getElementById("shift_day").value = day;
        document.getElementById("shift_start").value = start_time;
        document.getElementById("current_id").value = id;
        document.getElementById("shift_end").title="";
        
        
        var end_shift = end_time;   
        var time_list = document.getElementById("shift_start");
        var end_list = document.getElementById("shift_end");
        end_list.options.length = 0;
        
        for(var x = 0; x < time_list.length; x++){
            if(end_shift == time_list.options[x].value)
                var index = x;
        }
        
        var time_to_add = time_list.length - index; 
        
        for(x = 0; x < time_to_add;x++){
            var option = document.createElement("Option");
            option.value = time_list.options[index].value;
            option.text = time_list.options[index].text;
            end_list.options[x] = option;
            index++;
        }
        
        var update_options = document.getElementById("update_choice");
        
        update_options.options.length=0;
        
        var option_one = document.createElement("Option");
        option_one.text="Update";
        option_one.value="update";
        
        var option_two = document.createElement("Option");
        option_two.text="Delete";
        option_two.value="delete";
        
        update_options.options[0]=option_one;
        update_options.options[1]=option_two;
    }
</script>