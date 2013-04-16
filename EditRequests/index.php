<?php
include_once'../../Subway/HelperFiles/employeeClass.php';
include_once'../../Subway/HelperFiles/requestClass.php';

session_start();

include_once'../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

$request_array = array();
$emp_array = array();

$sqlCommand = "SELECT employee_id, first_name, last_name FROM subway.employee";
$result = mysqli_query($db_connect,$sqlCommand);

while($row = mysqli_fetch_array($result)){
    
    $employee = new employeeClass;
    $employee->setEmployeeID($row["employee_id"]);
    $employee->setEmployeeFirstName($row["first_name"]);
    $employee->setEmployeeLastName($row["last_name"]);
    array_push($emp_array,$employee);
}

$sqlCommand = "SELECT request_id, employee_id, start_date, end_date, start_time, end_time FROM subway.request";
$result = mysqli_query($db_connect, $sqlCommand);

while ($row = mysqli_fetch_array($result)){

    $request = new requestClass;
    
    $request->setRequestID($row["request_id"]);
    $request->setEmployeeID($row["employee_id"]);
    $request->setStartDate($row["start_date"]);
    $request->setEndDate($row["end_date"]);
    $request->setStartTime($row["start_time"]);
    $request->setEndTime($row["end_time"]);
    
    $start_explode = explode("-",$request->getStartDate());
    $end_explode = explode("-",$request->getEndDate());
    
    $request->setStartMonth($start_explode[1]);
    $request->setStartDay($start_explode[2]);
    $request->setEndMonth($end_explode[1]);
    $request->setEndDay($end_explode[2]);
    
    for($x=0;$x<count($emp_array);$x++){
        
        if($emp_array[$x]->getEmployeeID() == $request->getEmployeeID()){
            
            $request->setFirstName($emp_array[$x]->getEmployeeFirstName());
            $request->setLastName($emp_array[$x]->getEmployeeLastName());
        }
    }
    array_push($request_array,$request);
}

$_SESSION['request_array']=$request_array;

?>
<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <script type="text/javascript" src="/HelperFiles/JS/setTime.js"></script>
        <title></title>
    </head>
    <body>
        <div id="page_top">
            <div id="top_image">
                <img src="/Images/temp_top_logo_3.png" id="image" align="center">
            </div>

            <ul class="subway_tabs">
                <li><a href="/MainMenu/index.php">Home</a></li>
                <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule</a></li>
                <li><a href="/ManageEmployee/index.php">Employees</li>
                <li class="current_position">Requests</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules</a></li>
            </ul>       
        
            <div id="tab_bar"></div>
    
            <div id="normal_body">
                
                <div id="request_left">
                    
                    <table>
                        <tr><th id="table_title" colspan="2">Edit Requests</th></tr>
                        
                        <form action ="/HelperFiles/validateRequests.php" method="POST">
                            
                            <tr><td>First Name:</td>
                                <td><input type="text" id="first_name" name="first_name" readonly></td>
                            </tr>
                            <tr><td>Last Name:</td>
                                <td><input type="text" id="last_name" name="last_name" readonly></td>
                            </tr>
                            <tr>
                                <td>Start Date:</td>
                                <td>Month:
                                <select id="start_request_month" name="start_request_month" onChange ="startDate();">
                                        <option value="default">-----</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td></td>
                                <td>Day:
                                    <select id="start_request_day"  name="start_request_day" onChange="startDay();">
                                        
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>End Date:</td>
                            
                                <td>Month:
                                <select id="end_request_month" name="end_request_month" onChange="endDate();">
                                       
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td><td>Day:
                                    <select id="end_request_day"  name="end_request_day">
                                       
                                    </select>
                                </td>
                            </tr>
                            </tr>
                            <tr>
                                <td>Start Time</td>
                                <td><select id="start_request" name="start_request" onChange ="startTime('start_request')">
                                        <option value="first">---</option>
                                        <option value="entire_day">Entire Day</option>
                                        <option value="600">6:00</option>
                                        <option value="700">7:00</option>
                                        <option value="800">8:00</option>
                                        <option value="900">9:00</option>
                                        <option value="1000">10:00</option>
                                        <option value="1100">11:00</option>
                                        <option value="1200">12:00</option>
                                        <option value="1300">1:00</option>
                                        <option value="1400">2:00</option>
                                        <option value="1500">3:00</option>
                                        <option value="1600">4:00</option>
                                        <option value="1700">5:00</option>
                                        <option value="1800">6:00</option>
                                        <option value="1900">7:00</option>
                                        <option value="2000">8:00</option>
                                        <option value="2100">9:00</option>
                                        <option value="2200">10:00</option>
                                    </select>        
                                </td>
                            </tr>
                            <tr>
                                <td>End Time</td>
                                <td><select id="end_request" name="end_request">
                                        
                                    </select>
                                </td>
                            </tr>
                            
                            <tr><td>Update Option:</td>
                                <td><select id="update_choice" name="update_choice">
                                        <option value="add">Add</option>
                                        <option value="update">Update</option>
                                        <option value="delete">Delete</option>
                                    </select>
                                </td></tr>
                            <tr><td colspan="4"><input type="button" value="Reset" onclick="resetForm();"></td></tr>            
                            <tr><td colspan="4"><input type="submit" value="Enter Request"></td></tr>
                                <input type="hidden" id="employee_id" name="employee_id">
                                <input type="hidden" id="request_id" name="request_id">
                            
                        </form>
                    </table>
                </div>
                
                <div id="request_right">
                    
                    <table>
                        
                        <tr><th id="table_title" colspan="7">Current Requests</th></tr>
                        <tr><th></th>
                            <th>Employee</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                        
                        <?php
                        
                            for($x=0;$x<count($request_array);$x++){
                                
                                $first_name = $request_array[$x]->getFirstName();
                                $last_name = $request_array[$x]->getLastName();
                                $req_id = $request_array[$x]->getRequestID();
                                $emp_id = $request_array[$x]->getEmployeeID();
                                $start_month = $request_array[$x]->getStartMonth();
                                $start_day = $request_array[$x]->getStartDay();
                                $end_month = $request_array[$x]->getEndMonth();
                                $end_day = $request_array[$x]->getEndDay();
                                $start_time = $request_array[$x]->getStartTime();
                                $end_time = $request_array[$x]->getEndTime();
                                
                                echo "<tr><td>";
                                echo "<input type='radio' id='current' name='current' 
                                    onclick ='clearTable();insertRequests(\"$req_id\",\"$emp_id\",\"$first_name\",\"$last_name\"
                                                              ,\"$start_month\",\"$start_day\",\"$end_month\",
                                                             \"$end_day\",\"$start_time\",\"$end_time\");'>";
                                echo "</td><td>";
                                echo $first_name;
                                echo  " ";
                                echo $last_name;
                                echo "</td><td>";
                                echo $request_array[$x]->getStartDate();
                                echo "</td><td>";
                                echo $request_array[$x]->getEndDate();
                                echo "</td><td>";
                                echo $request_array[$x]->getStartTime();
                                echo "</td><td>";
                                echo $request_array[$x]->getEndTime();
                                echo "</td></tr>";
                            }
                        ?>
                        
                    </table>
                </div>
                
                <div id="request_far_right">
                    
                    <table> 
                        <tr><th id="table_title" colspan="3">Employee List </th></tr>
                        <?php
                            
                            for($x=0;$x<count($_SESSION['employee_array']);$x++){
                   
                                $first = $_SESSION['employee_array'][$x]->getEmployeeFirstName();
                                $last = $_SESSION['employee_array'][$x]->getEmployeeLastName();
                                $id = $_SESSION['employee_array'][$x]->getEmployeeID();
                                
                                echo "<tr><td>";
                                echo "<input type= 'radio' id='employee' name='employee' onclick='clearList(); insertEmployeeRequest(\"$first\",\"$last\",\"$id\");'>";
                                echo "</td><td>";
                                echo $first;
                                echo " ";
                                echo $last;
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
    
    function resetForm(){
        
        document.getElementById("start_request_month").value = "default";
        document.getElementById("start_request").value = "first";
        
        document.getElementById("first_name").value = "";
        document.getElementById("last_name").value = "";
        document.getElementById("end_request").options.length=0;
        document.getElementById("end_request_month").options.length=0;
        document.getElementById("end_request_day").options.length=0;
        document.getElementById("start_request_day").options.length=0;
        
        var update = document.getElementById("update_choice");
        
        update.options.length = 0; 
        
        var option = document.createElement("Option");
        option.text = "Add";
        option.value = "add";
        update.options[0] = option;
        
        var option1 = document.createElement("Option");
        option1.text = "Update";
        option1.value = "update";
        update.options[1] = option1;
        
        var option2 = document.createElement("Option");
        option2.text = "Delete";
        option2.value = "delete";
        update.options[2]=option2;
    }
   
    function clearList(){
        
       
        var request_list = document.getElementsByName("current");
        var update_choice = document.getElementById("update_choice");
        for(var x =0; x < request_list.length; x++){
            request_list[x].checked = false; 
        }    
        
        update_choice.options.length = 0; 
        var option = document.createElement("Option");
        option.text = "Add";
        option.value = "add";
        update_choice.options[0]=option;
        
        resetForm();
    }
    
    function clearTable(){
            var emp_list = document.getElementsByName("employee");
 
            for(var x = 0; x < emp_list.length; x++){
                emp_list[x].checked = false; 
            }
            
            
    }
</script>