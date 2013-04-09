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
                        unset($_SESSION['no_day_selected']);
                    }
                ?>
                
                
                <div id="request_left">
                    
                    <table>
                        <tr><th id="table_title" colspan="4">Edit Requests</th></tr>
                        
                        <form action ="/HelperFiles/validateRequests.php" method="POST">
                            
                            <tr><td>First Name:</td>
                                <td><input type="text" id="first_name" name="first_name" readonly></td>
                            </tr>
                            <tr><td>Last Name:</td>
                                <td><input type="text" id="last_name" name="last_name" readonly></td>
                            </tr>
                            <tr><td colspan="2">Request Day:</td></tr>
                                <tr><td colspan="2">Wednesday:<input type="checkbox" id="wed_check" name="wed_check" value="wednesday"></td></tr>
                                <tr><td colspan="2">Thursday:<input type="checkbox" id="thur_check" name="thur_check" value="thursday"></td></tr>
                                <tr><td colspan="2">Friday:<input type="checkbox" id="fri_check" name="fri_check" value="friday"></td></tr>
                                <tr><td colspan="2">Saturday:<input type="checkbox" id="sat_check" name="sat_check" value="saturday"></td></tr>
                                <tr><td colspan="2">Sunday:<input type="checkbox" id="sun_check" name="sun_check" value="sunday"></td></tr>
                                <tr><td colspan="2">Monday:<input type="checkbox" id="mon_check" name="mon_check" value="monday"></td></tr>
                                <tr><td colspan="2">Tuesday:<input type="checkbox" id="tues_check" name="tues_check" value="tuesday"></td></tr>
                            </tr>
                            <tr>
                                <td>Start Time</td>
                                <td><select id="start_request" name="start_request">
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
</script>
    
