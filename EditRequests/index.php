<?php
include_once'../../Subway/HelperFiles/employeeClass.php';

session_start();
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

if(isset($_SESSION['no_product']))
    unset($_SESSION['no_product']);
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
                                        <option>-----</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
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
                                        <option value="entire_day">Entire Day</option>
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
    
    function startDay(){
        
        var start_month_selected = document.getElementById("start_request_month").value;
        var end_month_selected = document.getElementById("end_request_month").value;
        var start_day_selected = document.getElementById("start_request_day").value;
        
        var start_day_list = document.getElementById("start_request_day");
        
        var day_list = document.getElementById("end_request_day");
     
        var days_to_add = start_day_list.options.length - start_month_selected +1;
        var index = start_day_selected -1;
        
        if(start_month_selected == end_month_selected){
       
            day_list.options.length = 0; 
            
            var option = document.createElement("Option");
            
            for(var x = 0; x < days_to_add; x++){
                
                var option = document.createElement("Option");
                option.text = start_day_list[index+1].text;
                option.value = start_day_list[index+1].value;
                day_list.options[x] = option;
                index++;  
            }
        }
    }
    
    function startDate(){
        
        //Variable the value of the month selected by the user
        var month_selected = document.getElementById("start_request_month").value;
        
        //These variables will hold the entire select object instead of the selected option.
        var end_month_list = document.getElementById("end_request_month");
        var end_day_list = document.getElementById("end_request_day");
        var total_months = document.getElementById("start_request_month");
        var day_list = document.getElementById("start_request_day");
        
        //Variable to determine how many months need to be added to the end request 
        //date month drop down list. 
        var months_to_add = 12 - month_selected +1;
        var index = month_selected;
       
        end_day_list.options.length=0;
        end_month_list.options.length = 0; 
       
        for(var i = 0; i < months_to_add;i++){
            var option = document.createElement("Option");
            option.text = total_months.options[index].text;
            option.value = total_months.options[index].value;
            end_month_list.options[i] = option;         
            index++;  
        }
        
        day_list.options.length = 0;
        
        var option = document.createElement("Option");
        option.text = "---";
        day_list.options[0]=option;
        
        if(month_selected == "1" || month_selected == "12" || month_selected == "3" ||
            month_selected == "5" || month_selected == "7" || month_selected == "8" || month_selected == "10"){
             
            for(var i = 1; i < 32; i++){
                var option = document.createElement("Option");
                option.text = i;
                option.value = i;
                day_list.options[i] = option;   
            }
        }
        if(month_selected == "2"){
             
            for(var i = 1; i < 29; i++){
                var option = document.createElement("Option");
                option.text = i;
                option.value = i;
                day_list.options[i] = option;
            }
        }
        if(month_selected == "4" || month_selected == "6" || month_selected == "11"){
           
            for(var i = 1; i < 31; i++){
                var option = document.createElement("Option");
                option.text = i;
                option.value = i;
                day_list.options[i] = option;
            }
        }
        if(month_selected == "9"){
            
            for(var i = 1; i < 30; i++){
                var option = document.createElement("Option");
                option.text = i;
                option.value = i;
                day_list.options[i] = option;    
            }
        }
    }
    function endDate(){
        
        var start_month = document.getElementById("start_request_month").value;
        var end_month = document.getElementById("end_request_month").value;
        var end_day_list = document.getElementById("end_request_day");
        
        if(start_month == end_month){
            startDay();
        }
        else{
            
            var month_selected = document.getElementById("end_request_month").value;
            var day_list = document.getElementById("start_request_day");
            
            end_day_list.options.length = 0;
            day_list.options.length = 0; 
            
            var option = document.createElement("Option");
            option.text = "---";
            day_list.options[0] = option;
            
           
            document.getElementById("start_request_month").value = month_selected;
   
            if(month_selected == "1" || month_selected == "12" || month_selected == "3" ||
                month_selected == "5" || month_selected == "7" || month_selected == "8" || month_selected == "10"){
   
                for(var i = 1; i < 32; i++){
                
                    var option = document.createElement("Option");
                    option.text = i;
                    option.value = i;
                    day_list.options[i] =option;    
                }
            }
            if(month_selected == "2"){
                
                for(var i = 1; i < 29; i++){
                    var option = document.createElement("Option");
                    option.text = i;
                    option.value = i;
                    day_list.options[i] = option; 
                }
            }
            if(month_selected == "4" || month_selected == "6" || month_selected == "11"){
             
                for(var i = 1; i < 31; i++){
                    var option = document.createElement("Option");
                    option.text = i;
                    option.value = i;
                    day_list.options[i] = option;
                }
            }
            if(month_selected == "9"){
           
                for(var i = 1; i < 30; i++){
                    var option = document.createElement("Option");
                    option.text = i;
                    option.value = i;
                    day_list.options[i] = option;
                }
            }
        }
    }
</script>
    
