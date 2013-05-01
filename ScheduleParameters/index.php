<?php

/*Start Session*/
session_start();

/*Included files*/
include_once'../../Subway/HelperFiles/unsetEmpFields.php';
include_once'../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/businessRuleClass.php';

/*query command*/
$sqlCommand = 'SELECT busn_rule_id,store_id,descr,value0,value1 FROM subway.parameters';

$result = mysqli_query($db_connect, $sqlCommand);

/*Array to hold business rules*/
$business_rule_array = array();

while($row = mysqli_fetch_array($result)){
    
    /*New Business Rule Object*/
    $business_rule = new businessRuleClass;
    
    /*Assign database values to business rule object*/
    $business_rule->setRuleID($row['busn_rule_id']);
    $business_rule->setStoreID($row['store_id']);
    $business_rule->setRuleDescription($row['descr']);
    $business_rule->setRuleValueOne($row['value0']);
    $business_rule->setRuleValueTwo($row['value1']);
    
    /*put business rule object into array to hold all rules*/
    array_push($business_rule_array,$business_rule);
}
$_SESSION['schedule_parameters'] = $business_rule_array;
?>

<!DOCTYPE html>
<html>
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        
        <title>Business Rules</title>
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
            <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
            <li><a href="/ManageEmployee/index.php">Employees</a</li>
            <li><a href="/EditRequests/index.php">Requests</a></li>
            <li class="current_position">Business Rules</li>
        </ul>      
         
         <div id="tab_bar"></div>
          
        <div id="small_body">
        
            <div id="employee_left"> 
                <form action ="/HelperFiles/validateParameterChanges.php" method="POST">
            <table>
                <tr><th id="table_title" colspan="2">Edit Scheduling Parameters</th></tr>
                <tr><td>Description:</td><td><input type="text" id="rule_description" name="rule_descripton" value="" readonly title="Read Only!"></td></tr>
                <tr><td>Value:</td><td><input type="text" id="rule_value_one" name="rule_value_one"></td></tr>
                <tr><td colspan="2"><input type="button" value="Reset" onclick="resetList();"></td></tr>
                <tr><td colspan="2"><input type="submit" value="Update"></td></tr>
            </table>
            </div>
            
            <input type="hidden" id="store_id" name="store_id" value="">
            <input type="hidden" id="rule_id" name="rule_id" value="">
                
            </form>
            
            <div id="employee_right">
            <table>
                <tr><th colspan="3" id="table_title">Subway Scheduling Parameters</th></tr>
                <tr><th id="row_title"></th>
                    <th id="row_title">Description:</th>
                    <th id="row_title">Value:</th>
                </tr>
                <?php
                
                    /*For loop to put all existing rules into a drop down box*/
                    for($x=0; $x<count($business_rule_array);$x++){
                        
                        $rule_id = $business_rule_array[$x]->getRuleID();
                        $store_id = $business_rule_array[$x]->getStoreID();
                        $description = $business_rule_array[$x]->getRuleDescription();
                        $value_one = $business_rule_array[$x]->getRuleValueOne();
                       
                        echo "<tr><td><input type='radio' id='business_rule' name='business_rule' 
                            onclick='displayRuleValues($x,\"$rule_id\",\"$store_id\",\"$description\",\"$value_one\");'>";
                        echo "</td><td>";
                        echo $business_rule_array[$x]->getRuleDescription();
                        echo "</td><td>";
                        echo $business_rule_array[$x]->getRuleValueOne();
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

    function resetList(){
        
        var list = document.getElementsByName('business_rule');
        
        for(var x = 0; x < list.length; x++){
            
            if(list[x].checked == true)
                list[x].checked = false;
        }
        
        document.getElementById('rule_description').value ="";
        document.getElementById('rule_value_one').value = ""; 
    }

    function displayRuleValues(index,rule_id,store_id,description,value_one){
          
        document.getElementById('rule_description').value = description;
        document.getElementById('rule_value_one').value = value_one;
        document.getElementById('store_id').value = store_id;
        document.getElementById('rule_id').value = rule_id;
    }
</script>