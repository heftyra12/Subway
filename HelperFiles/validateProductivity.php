<?php
include_once'productivityClass.php';
include_once'config.php';

session_start();

$week_number = $_POST['week_list'];
$wed_prod = $_POST['wed_prod'];
$thurs_prod = $_POST['thurs_prod'];
$fri_prod = $_POST['fri_prod'];
$sat_prod = $_POST['sat_prod'];
$sun_prod = $_POST['sun_prod'];
$mon_prod = $_POST['mon_prod'];
$tues_prod = $_POST['tues_prod'];
$update_choice = $_POST['update_choice'];

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

if($update_choice === "Add"){
    
    for($x=0;$x<count($prod_array);$x++){
    
        $day = $x+1;
        $addSQLCommand = "INSERT INTO subway.productivity(store_id,week_no,day,units)
            VALUES('1','$week_number','$day','$prod_array[$x]')";
    
        mysqli_query($db_connect,$addSQLCommand);   
    }
}
if($update_choice === "Update"){
    
    for($x=0;$x<count($prod_array);$x++){
        
        $day = $x+1;
        
        $updateSQLCommand = "UPDATE subway.productivity SET units ='$prod_array[$x]' WHERE week_no ='$week_number' AND day ='$day' AND store_id ='1'";
        
        mysqli_query($db_connect,$updateSQLCommand); 
    }  
}
header("Location: /ManageSchedule/productivity.php");
?>
