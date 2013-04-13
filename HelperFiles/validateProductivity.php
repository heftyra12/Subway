<?php
include_once'productivityClass.php';
session_start();

include_once'config.php';

$week_number = $_POST['week_list'];

$wed_prod = $_POST['wed_prod'];
$thurs_prod = $_POST['thurs_prod'];
$fri_prod = $_POST['fri_prod'];
$sat_prod = $_POST['sat_prod'];
$sun_prod = $_POST['sun_prod'];
$mon_prod = $_POST['mon_prod'];
$tues_prod = $_POST['tues_prod'];

$new_prod = new productivityClass;

$new_prod->setStoreNumber(1);
$new_prod->setWeekNumber($week_number);
$new_prod->setWedProd($wed_prod);
$new_prod->setThursProd($thurs_prod);
$new_prod->setFriProd($fri_prod);
$new_prod->setSatProd($sat_prod);
$new_prod->setSunProd($sun_prod);
$new_prod->setMonProd($mon_prod);
$new_prod->setTuesProd($tues_prod);

$prod_array = $new_prod->getAllProd();


for($x=0;$x<count($prod_array);$x++){
    
    $day = $x+1;
    $addSQLCommand = "INSERT INTO subway.productivity(store_id,week_no,day,units)
        VALUES('1','$week_number','$day','$prod_array[$x]')";
    
    mysqli_query($db_connect,$addSQLCommand);   
}
header("Location: /ManageSchedule/productivity.php");
?>
