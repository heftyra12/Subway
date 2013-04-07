<?php

session_start();

include_once'config.php';

$wed_prod = $_POST['wed_prod'];
$thur_prod = $_POST['thur_prod'];
$fri_prod = $_POST['fri_prod'];
$sat_prod = $_POST['sat_prod'];
$sun_prod = $_POST['sun_prod'];
$mon_prod = $_POST['mon_prod'];
$tues_prod = $_POST['tues_prod'];

$sqlCommand = "UPDATE subway.productivity SET wed_prod ='$wed_prod', thur_prod='$thur_prod',fri_prod='$fri_prod',
    sat_prod='$sat_prod',sun_prod='$sun_prod',mon_prod='$mon_prod',tues_prod='$tues_prod'";

mysqli_query($db_connect,$sqlCommand);

header("Location: /ManageSchedule/productivity.php");
?>
