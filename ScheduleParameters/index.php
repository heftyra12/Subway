<?php

/*Start Session*/
session_start();

/*Included files*/
include_once'../../Subway/HelperFiles/unsetEmpFields.php';
include_once'../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/businessRuleClass.php';

if(isset($_SESSION['no_product']))
    unset($_SESSION['no_product']);

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
        
        <title></title>
    </head>
    <body>
        
         <div id="page_top"/>
         
            <div id="top_image">    
                <img src="/Images/temp_top_logo_3.png" align="center">
            </div>
         
           <ul class="subway_tabs">
            <li><a href="/MainMenu/index.php">Home:</a></li>
            <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
            <li><a href="/ViewSchedule/index.php">View Schedule:</a></li>
            <li><a href="/ManageEmployee/index.php">Employees:</a</li>
            <li><a href="/EditRequests/index.php">Requests:</a></li>
            <li class="current_position">Business Rules:</li>
        </ul>      
         
         <div id="tab_bar"></div>
          
        <div id="normal_body">
        
            <div id="employee_left"> 
                <form action ="/HelperFiles/validateParameterChanges.php" method="POST">
            <table>
                <tr><th id="table_title" colspan="2">Edit Scheduling Parameters</th></tr>
                <tr><td>Description:</td><td><input type="text" id="rule_description" name="rule_descripton" value="" readonly></td></tr>
                <tr><td>Value:</td><td><input type="text" id="rule_value_one" name="rule_value_one"></td></tr>
                <tr><td></td><td><input type="submit" value="Update"></td></tr>
            </table>
            </div>
            
            <input type="hidden" id="store_id" name="store_id" value="">
            <input type="hidden" id="rule_id" name="rule_id" value="">
                
            </form>
            
            <div id="employee_right">
            <table>
                <tr><th colspan="4" id="table_title">Subway Scheduling Parameters</th></tr>
                <?php
                
                    /*For loop to put all existing rules into a drop down box*/
                    for($x=0; $x<count($business_rule_array);$x++){
                        
                        $rule_id = $business_rule_array[$x]->getRuleID();
                        $store_id = $business_rule_array[$x]->getStoreID();
                        $description = $business_rule_array[$x]->getRuleDescription();
                        $value_one = $business_rule_array[$x]->getRuleValueOne();
                       
                        echo "<tr><td><input type='radio' id='business_rule' name='business_rule' value='' 
                            onclick='displayRuleValues($x,\"$rule_id\",\"$store_id\",\"$description\",\"$value_one\");'>";
                        echo "</td><td>";
                        echo $business_rule_array[$x]->getRuleDescription();
                        echo "</td><td>";
                        echo $business_rule_array[$x]->getRuleValueOne();
                        echo "</td><td>";
                        echo $business_rule_array[$x]->getRuleValueTwo();
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

    function displayRuleValues(index,rule_id,store_id,description,value_one){
        
        var array_index = index;
        var rule_id = rule_id;
        var store_id = store_id;
        var rule_description = description;
        var value_one = value_one;
        
        document.getElementById('rule_description').value = rule_description;
        document.getElementById('rule_value_one').value = value_one;
        document.getElementById('store_id').value = store_id;
        document.getElementById('rule_id').value = rule_id;
    }
</script>