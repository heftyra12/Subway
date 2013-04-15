<?php
session_start();

if($_SESSION['current_prod'] != true){
    header("Location: productivity.php");
}

include_once '../../Subway/HelperFiles/config.php';
include_once '../../Subway/HelperFiles/employeeClass.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

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
            
                <form action="edit.php" method="POST">
                    <input type="submit" value="Edit Schedule" class="subway_buttons"/>
                </form>
            </div>
        </div>

        <div id="normal_right">
           
            <div id="home_sched">   
                
                <form action="/HelperFiles/getSchedule.php" method="POST">
                
                    <table>
                 
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
                        echo "<input type='hidden' id='test' value=\"$array\">";
                        echo "<tr><td class='sched_emp'>";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeFirstName()." ";
                        echo $_SESSION['schedule_array'][$x]->getEmployeeLastName()."</td>";
                        
                        echo "<td><select id='wed_start' name='wed_start' onChange='selectTime();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "<option value='750'>7:30</option>";
                        echo "<option value='800'>8:00</option>";
                        echo "</select>";
                        
                        echo "<select id='wed_end' name='wed_end'>";
                        echo "</select>";
                      
                        echo "<select id='wed_shift' name='wed_shift' onChange='selectShift();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='1'>1st</option>";
                        echo "<option value='2'>2nd</option>";
                        echo "<option value='3'>3rd</option>";
                        echo "</select></td>";
                        
                        echo "<td><select id='wed_start' name='wed_start' onChange='selectTime();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "</select>";
                        
                        echo "<select id='wed_end' name='wed_end'>";
                        echo "</select>";
                      
                        echo "<select id='wed_shift' name='wed_shift' onChange='selectShift();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='1'>1st</option>";
                        echo "<option value='2'>2nd</option>";
                        echo "<option value='3'>3rd</option>";
                        echo "</select></td>";
                        
                        echo "<td><select id='wed_start' name='wed_start' onChange='selectTime();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "</select>";
                        
                        echo "<select id='wed_end' name='wed_end'>";
                        echo "</select>";
                      
                        echo "<select id='wed_shift' name='wed_shift' onChange='selectShift();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='1'>1st</option>";
                        echo "<option value='2'>2nd</option>";
                        echo "<option value='3'>3rd</option>";
                        echo "</select></td>";
                        
                        echo "<td><select id='wed_start' name='wed_start' onChange='selectTime();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "</select>";
                        
                        echo "<select id='wed_end' name='wed_end'>";
                        echo "</select>";
                      
                        echo "<select id='wed_shift' name='wed_shift' onChange='selectShift();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='1'>1st</option>";
                        echo "<option value='2'>2nd</option>";
                        echo "<option value='3'>3rd</option>";
                        echo "</select></td>";
                        
                        echo "<td><select id='wed_start' name='wed_start' onChange='selectTime();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "</select>";
                        
                        echo "<select id='wed_end' name='wed_end'>";
                        echo "</select>";
                      
                        echo "<select id='wed_shift' name='wed_shift' onChange='selectShift();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='1'>1st</option>";
                        echo "<option value='2'>2nd</option>";
                        echo "<option value='3'>3rd</option>";
                        echo "</select></td>";
                        
                        echo "<td><select id='wed_start' name='wed_start' onChange='selectTime();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "</select>";
                        
                        echo "<select id='wed_end' name='wed_end'>";
                        echo "</select>";
                      
                        echo "<select id='wed_shift' name='wed_shift' onChange='selectShift();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='1'>1st</option>";
                        echo "<option value='2'>2nd</option>";
                        echo "<option value='3'>3rd</option>";
                        echo "</select></td>";
                        
                        echo "<td><select id='wed_start' name='wed_start' onChange='selectTime();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='600'>6:00</option>";
                        echo "<option value='650'>6:30</option>";
                        echo "<option value='700'>7:00</option>";
                        echo "</select>";
                        
                        echo "<select id='wed_end' name='wed_end'>";
                        echo "</select>";
                      
                        echo "<select id='wed_shift' name='wed_shift' onChange='selectShift();'>";
                        echo "<option value='default'>---</option>";
                        echo "<option value='1'>1st</option>";
                        echo "<option value='2'>2nd</option>";
                        echo "<option value='3'>3rd</option>";
                        echo "</select></td>";
                        
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

<script languate="Javascript">

    function selectTime(){
        
        
       var blah = document.getElementById('test');
       
       for(var x = 0; x < blah.length;x++){
           
        alert(blah[x]);
        
       }
        
       document.getElementById('wed_shift').value="default";
    }

    function selectShift(){
        
        
        document.getElementById('wed_start').value="default";
        
    }

    
</script>
    
