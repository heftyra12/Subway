<?php

session_start();

include_once'config.php';

$rule_id = $_POST['rule_id'];
$store_id = $_POST['store_id'];
$value_one = $_POST['rule_value_one'];
$value_two = $_POST['rule_value_two'];
$rule_description = $_POST['rule_description'];

$sqlCommand = "UPDATE subway.parameters SET value0 ='$value_one' WHERE busn_rule_id ='$rule_id' AND store_id='$store_id'";

 mysqli_query($db_connect,$sqlCommand);
 header("Location: /ScheduleParameters/index.php");

?>
