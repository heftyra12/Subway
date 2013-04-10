<?php
include_once'../../Subway/HelperFiles/employeeClass.php';

session_start();
include_once'../../Subway/HelperFiles/unsetEmpFields.php';


if(isset($_SESSION['no_product']))
    unset($_SESSION['no_product']);

if(!isset($_SESSION['no_day_selected']))
    $_SESSION['no_day_selected']="false";
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
                <div id="test">
                <li><a href="/MainMenu/index.php">Home:</a></li>
                <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule</a></li>
                <li><a href="/ManageEmployee/index.php">Employees</li>
                <li class="current_position">Requests</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules</a></li>
                <div id="text">
            </ul>       
        
            <div id="tab_bar"></div>
    
            <div id="normal_body">
                 
                <?php
                    if($_SESSION['no_day_selected'] === "true"){   
                        echo "<script language=javascript>alert('Error: At least one request day must be selected.')</script>";
                    }
                ?>
                
                
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
                                    <select id="start_request_day"  name="start_request_day">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>End Date:</td>
                            
                                <td>Month:
                                <select id="end_request_month" name="end_request_month" onChange ="endDate();">
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
                            <tr>
                                <td></td><td>Day:
                                    <select id="end_request_day"  name="end_request_day">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>   
                                    </select>
                                </td>
                            </tr>
                            </tr>
                            <tr>
                                <td>Start Time</td>
                                <td><select id="start_request" name="start_request">
                                        <option value="entire_day">Entire Day</option>
                                        <option value="0600" onclick="test('0600');">06:00</option>
                                        <option value="0700">07:00</option>
                                        <option value="0800">08:00</option>
                                        <option value="0900">09:00</option>
                                        <option value="1000">10:00</option>
                                        <option value="1100">11:00</option>
                                        <option value="1200">12:00</option>
                                        <option value="1300">01:00</option>
                                        <option value="1400">02:00</option>
                                        <option value="1500">03:00</option>
                                        <option value="1600">04:00</option>
                                        <option value="1700">05:00</option>
                                        <option value="1800">06:00</option>
                                        <option value="1900">07:00</option>
                                        <option value="2000">08:00</option>
                                        <option value="2100">09:00</option>
                                        <option value="2200">10:00</option>
                                    </select>        
                                </td>
                            </tr>
                            <tr>
                                <td>End Time</td>
                                <td><select id="end_request" name="end_request">
                                        <option>Entire Day</option>
                                        <option value="0600">06:00</option>
                                        <option value="0700">07:00</option>
                                        <option value="0800">08:00</option>
                                        <option value="0900">09:00</option>
                                        <option value="1000">10:00</option>
                                        <option value="1100">11:00</option>
                                        <option value="1200">12:00</option>
                                        <option value="1300">01:00</option>
                                        <option value="1400">02:00</option>
                                        <option value="1500">03:00</option>
                                        <option value="1600">04:00</option>
                                        <option value="1700">05:00</option>
                                        <option value="1800">06:00</option>
                                        <option value="1900">07:00</option>
                                        <option value="2000">08:00</option>
                                        <option value="2100">09:00</option>
                                        <option value="2200">10:00</option>
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
                                        
                            <tr><td colspan="4"><input type="submit" value="Enter Request"></td><tr>
                            
                        </form>
                         
                    </table>
                </div>
                
                <div id="request_right">
                    
                    <table>
                        
                        <tr><th id="table_title">Current Requests</th></tr>
                        
                        <?php
                            echo "<tr><td>";
                            echo "<input type='radio' onclick='insertRequests();'>";
                            echo "</td></tr>";
                        ?>
                        
                    </table>
                </div>
                
                <div id="request_far_right">
                    
                    <table> 
                        <tr><th id="table_title" colspan="3">Employee List:</th></tr>
                        <?php
                            
                            for($x=0;$x<count($_SESSION['schedule_array']);$x++){
                   
                                $first = $_SESSION['schedule_array'][$x]->getEmployeeFirstName();
                                $last = $_SESSION['schedule_array'][$x]->getEmployeeLastName();
                                
                                echo "<tr><td>";
                                echo "<input type = 'radio' id='employee' name='employee' onclick='insertEmployee(\"$first\",\"$last\");'>";
                                echo "</td><td>";
                                echo $first;
                                echo "</td><td>";
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

<script language="Javascript">

    //Holder for function that will enter in values of a 
    //current request. 
    function insertRequests(){
        
      alert("in js function");  
    }
    
    //Inserts employee name into the edit request table. 
    //The text fields in that table are read only, so only 
    //current employees can have a request entered/edited/deleted
    function insertEmployee(first, last){
        
        $first = first; 
        $last = last;
        
        document.getElementById("first_name").value = first; 
        document.getElementById("last_name").value =last;
    }
    
    function startDate(){
        
        var month_selected = document.getElementById("start_request_month").value;
        var day_list = document.getElementById("start_request_day");
        var i;
   
        if(month_selected == "01" || month_selected == "12" || month_selected == "03" ||
            month_selected == "05" || month_selected == "07" || month_selected == "08" || month_selected == "10"){
   
            day_list.options.length = 0;
            
            for(i = 0; i < 31; i++){
                
                var option = document.createElement("Option");
                option.text = i+1;
                option.value = i+1;
                 
                day_list.options[i] =option;    
            }
        }
        if(month_selected == "02"){
            
           day_list.options.length = 0; 
            for(i = 0; i < 28; i++){
                
                var option = document.createElement("Option");
                option.text = i+1;
                option.value = i+1;
               
                day_list.options[i] = option; 
            }
        }
        if(month_selected == "04" || month_selected == "06" || month_selected == "11"){
            
            day_list.options.length = 0; 
            
            for(i = 0; i < 30; i++){
                
                var option = document.createElement("Option");
                option.text = i+1;
                option.value = i+1;
                
                day_list.options[i] = option;
            }
        }
        if(month_selected == "09"){
            
            day_list.options.length = 0; 
            
            for(i = 0; i < 29; i++){
                
                var option = document.createElement("Option");
                option.text = i+1;
                option.value = i+1;
                
                day_list.options[i] = option;
            }
        }
 
    }
    
    function endDate(){
        
        var month_selected = document.getElementById("end_request_month").value;
        var day_list = document.getElementById("end_request_day");
        var i;
   
        if(month_selected == "01" || month_selected == "12" || month_selected == "03" ||
            month_selected == "05" || month_selected == "07" || month_selected == "08" || month_selected == "10"){
   
            day_list.options.length = 0;
            
            for(i = 0; i < 31; i++){
                
                var option = document.createElement("Option");
                option.text = i+1;
                option.value = i+1;
                 
                day_list.options[i] =option;    
            }
        }
        if(month_selected == "02"){
            
           day_list.options.length = 0; 
            for(i = 0; i < 28; i++){
                
                var option = document.createElement("Option");
                option.text = i+1;
                option.value = i+1;
               
                day_list.options[i] = option; 
            }
        }
        if(month_selected == "04" || month_selected == "06" || month_selected == "11"){
            
            day_list.options.length = 0; 
            
            for(i = 0; i < 30; i++){
                
                var option = document.createElement("Option");
                option.text = i+1;
                option.value = i+1;
                
                day_list.options[i] = option;
            }
        }
        if(month_selected == "09"){
            
            day_list.options.length = 0; 
            
            for(i = 0; i < 29; i++){
                
                var option = document.createElement("Option");
                option.text = i+1;
                option.value = i+1;
                
                day_list.options[i] = option;
            }
        }
 
    }
</script>
    
