<?php
include_once'config.php';
include_once'shiftsClass.php';
session_start();

$day = $_POST['shift_day'];
$start_time = $_POST['shift_start'];
$end_time = $_POST['shift_end'];
$id = $_POST['current_id'];
$update_choice = $_POST['update_choice'];
$store_id = 1;
    
if($update_choice === "add"){
    $highest_id_value=0;
    
    for($x=0;$x<count($_SESSION['shift_array']);$x++){
        
        $array_id = $_SESSION['shift_array'][$x]->getShiftID();
           
        if($highest_id_value < $array_id){
            $highest_id_value = $array_id;
        }
    }
    
    $highest_id_value++;
    
    $addSQLCommand = "INSERT INTO subway.shifts (shift_id, store_id, day, start_time, end_time)
        VALUES('$highest_id_value', '$store_id', '$day', '$start_time', '$end_time')";
    
    mysqli_query($db_connect, $addSQLCommand);
}

if($update_choice === "update"){
    $updateSQLCommand = "UPDATE subway.shifts SET day ='$day', start_time ='$start_time', end_time ='$end_time'
        WHERE shift_id ='$id'";
    mysqli_query($db_connect,$updateSQLCommand);
}

if($update_choice === "delete"){
    $deleteSQLCommand = "DELETE FROM subway.shifts WHERE shift_id ='$id'";
    mysqli_query($db_connect,$deleteSQLCommand);
}
header("Location: /ManageSchedule/shifts.php");
?>
