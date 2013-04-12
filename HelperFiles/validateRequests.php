<?php
//Session Start
session_start();
//Include the db connection file.
include_once'config.php';

if(!isset($_SESSION['no_day_selected']))
    $_SESSION['no_day_selected'] = "false";


//Form Values
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$update_choice = $_POST['update_choice'];
$start_request = $_POST['start_request'];
$end_request = $_POST['end_request'];

$request_day_array = array();

if(isset($_POST['wed_check'])){
    $day = $_POST['wed_check'];
    array_push($request_day_array,$day);
}
if(isset($_POST['thur_check'])){
    $day = $_POST['thur_check'];
    array_push($request_day_array,$day);
}
if(isset($_POST['fri_check'])){
    $day = $_POST['fri_check'];
    array_push($request_day_array,$day);
}
if(isset($_POST['sat_check'])){
    $day = $_POST['sat_check'];
    array_push($request_day_array,$day);
}
if(isset($_POST['sun_check'])){
    $day = $_POST['sun_check'];
    array_push($request_day_array,$day);
}
if(isset($_POST['mon_check'])){
    $day = $_POST['mon_check'];
    array_push($request_day_array,$day);
}        
if(isset($_POST['tues_check'])){
    $day = $_POST['tues_check'];
    array_push($request_day_array,$day);
}

//User must select a day for the request. If no day is selected
//they are sent back to the form. 
if(empty($request_day_array)){
    
    $_SESSION['no_day_selected'] = "true";
    header("Location: /EditRequests/index.php");
}

for($x = 0; $x < count($request_day_array);$x++){
    echo $request_day_array[$x];
    echo "<br/>";
}

echo $first_name;
echo $last_name;
echo $update_choice;
echo $start_request;
echo $end_request;

$result = mysqli_query($db_connect, "select max(request_id)+1 as count from subway.request");        
while($row = mysqli_fetch_array($result)){
    $nextRequestId = $row["count"];
}

// got side-tracked and started working on this
// feel free to throw it away if you don't need it
$employee_id=2;
$start_date = '2013-05-18';
$end_date = '2013-05-20';
$start_time=600;
$end_time=2200;
$addRequestSQL = "INSERT INTO `subway`.`request` (`request_id`, `employee_id`,
    `start_date`, `end_date`, `start_time`, `end_time`) VALUES 
    ($nextRequestId, $employee_id, $start_date, $end_date, '$start_time, $end_time)";


if($update_choice ==="add"){
    //Here's an example of the query to insert:
    //INSERT INTO `subway`.`request` (`request_id`, `employee_id`, `start_date`,
    // `end_date`, `start_time`, `end_time`) VALUES ('1', '1', '2013-05-18',
    //  '2013-05-20', '600', '2200');
    mysqli_query($db_connect, $addRequestSQL);
    header("Location:/ManageEmployee/index.php");
    
    
}

if($update_choice ==="update"){
    
}
else{
    
    
}

?>
