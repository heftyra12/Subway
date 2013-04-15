<?php

include_once'requestClass.php';
//Session Start
session_start();
//Include the db connection file.
include_once'config.php';

//Form Values
$emp_id = $_POST['employee_id'];
$update_choice = $_POST['update_choice'];
$start_request_month = $_POST['start_request_month'];
$start_request_day = $_POST['start_request_day'];
$end_request_month = $_POST['end_request_month'];
$end_request_day = $_POST['end_request_day'];
$start_request = $_POST['start_request'];
$end_request = $_POST['end_request'];



$final_start = new DateTime();
$final_start->setDate(2013,$start_request_month,$start_request_day);
$fs =$final_start->format('Y-m-d');
 
$final_end = new DateTime();
$final_end->setDate(2013,$end_request_month,$end_request_day);
$fe = $final_end->format('Y-m-d');


if($update_choice === "add"){

    $request_id = 0; 
    
    for($x=0; $x < count($_SESSION['request_array']);$x++){
        
        if($request_id < $_SESSION['request_array'][$x]->getRequestID()){
            
            $request_id = $_SESSION['request_array'][$x]->getRequestID();
        }
    }
    
    $request_id++;
    
    $addSQLCommand = "INSERT INTO subway.request(request_id, employee_id, start_date, end_date, start_time, end_time)
                      VALUES('$request_id','$emp_id', '$fs', '$fe', '$start_request', '$end_request')";
    mysqli_query($db_connect,$addSQLCommand);  
}
if($update_choice === "update"){
    
    $request_id = $_POST['request_id'];
    
    $updateSQLCommand = "UPDATE subway.request
                         SET start_date ='$fs', end_date ='$fe', start_time = '$start_request', end_time ='$end_request'
                         WHERE request_id ='$request_id' AND employee_id ='$emp_id'";
    
    mysqli_query($db_connect,$updateSQLCommand);
}
if($update_choice === "delete"){
    
    $deleteSQLCommand = "DELETE FROM subway.request WHERE request_id ='$request_id'";
    mysqli_query($db_connect,$deleteSQLCommand);
}

header("Location:/EditRequests/index.php");
?>