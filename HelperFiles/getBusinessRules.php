<?php

include_once'businessRuleClass.php';

$business_rule_array = array();

$sqlCommand = 'SELECT busn_rule_id,store_id,descr,value0,value1 FROM subway.parameters';
$result = mysqli_query($db_connect, $sqlCommand);

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

$min_shift_hours = $business_rule_array[5]->getRuleValueOne();

$max_week_full = $business_rule_array[2]->getRuleValueOne();
$max_day_full = $business_rule_array[1]->getRuleValueOne();

$max_week_minor = $business_rule_array[0]->getRuleValueOne();

$max_week_part = $business_rule_array[4]->getRuleValueOne();
$max_day_part = $business_rule_array[3]->getRuleValueOne();

echo "<input type='hidden' id='min_shift_hours' value='$min_shift_hours'>";

echo "<input type='hidden' id='max_week_minor' value='$max_week_minor'>";

echo "<input type='hidden' id='max_day_full' value ='$max_day_full'>";
echo "<input type='hidden' id='max_day_part' value='$max_day_part'>";

echo "<input type='hidden' id='max_week_full' value='$max_week_full'>";
echo "<input type='hidden' id='max_week_part' value='$max_week_part'>";
?>
