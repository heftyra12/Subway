<?php
include_once'scheduleClass.php';
include_once'employeeClass.php';
session_start();
echo "<link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>";
$index = $_POST['index'] - 1;

//Function to convert time to make the schedule easier to read for employees
function convertTime($start_time, $end_time) {

    $converted_start_time = $start_time;
    $converted_end_time = $end_time;
    
    //return empty if no time is selected for a day. 
    if($start_time == "" && $end_time == ""){
        return "";
    }
    //if a shift is selected
    else if($end_time == "" && $start_time != ""){
        
        return $start_time;
    }
    //if the employee does not have the daty off and no shift is selected
    else{
        
        if ($start_time > 1200) {
        $converted_start_time = $start_time - 1200;
        }
        if ($end_time > 1200) {
            $converted_end_time = $end_time - 1200;
        }

        if(strlen($converted_start_time) > 3){
            $final_start_time = substr($converted_start_time, 0, 2) . ":" . substr($converted_start_time, 2, 4);
        } 
        else{
            $final_start_time = substr($converted_start_time, 0, 1) . ":" . substr($converted_start_time, 1, 3);
        }
        if (strlen($converted_end_time) > 3) {
            $final_end_time = substr($converted_end_time, 0, 2) . ":" . substr($converted_end_time, 2, 4);
        }       
        else {
            $final_end_time = substr($converted_end_time, 0, 1) . ":" . substr($converted_end_time, 1, 3);
        }
    
        return $final_start_time." - ".$final_end_time;
    }
}

// if we need the information somewhere else too
for ($x = 0; $x < $index; $x++) {

    $_SESSION['full_sched_array'][$x]->setWednesdayStart($_POST['wed_time_start_' . $x]);
    $_SESSION['full_sched_array'][$x]->setWednesdayEnd($_POST['wed_time_end_' . $x]);
    $_SESSION['full_sched_array'][$x]->setThursdayStart($_POST['thu_time_start_' . $x]);
    $_SESSION['full_sched_array'][$x]->setThursdayEnd($_POST['thu_time_end_' . $x]);
    $_SESSION['full_sched_array'][$x]->setFridayStart($_POST['fri_time_start_' . $x]);
    $_SESSION['full_sched_array'][$x]->setFridayEnd($_POST['fri_time_end_' . $x]);
    $_SESSION['full_sched_array'][$x]->setSaturdayStart($_POST['sat_time_start_' . $x]);
    $_SESSION['full_sched_array'][$x]->setSaturdayEnd($_POST['sat_time_end_' . $x]);
    $_SESSION['full_sched_array'][$x]->setSundayStart($_POST['sun_time_start_' . $x]);
    $_SESSION['full_sched_array'][$x]->setSundayEnd($_POST['sun_time_end_' . $x]);
    $_SESSION['full_sched_array'][$x]->setMondayStart($_POST['mon_time_start_' . $x]);
    $_SESSION['full_sched_array'][$x]->setMondayEnd($_POST['mon_time_end_' . $x]);
    $_SESSION['full_sched_array'][$x]->setTuesdayStart($_POST['tue_time_start_' . $x]);
    $_SESSION['full_sched_array'][$x]->setTuesdayEnd($_POST['tue_time_end_' . $x]);
    $_SESSION['full_sched_array'][$x]->setTotalHours($_POST['total_' . $x]);
}

echo "<table>";
echo "<tr><th class='table_title'>Schedule</th></tr>";
echo "<tr><th>Employee</th><th>Hours</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th><th>Sunday</th><th>Monday</th><th>Tuesday</th></tr>";
for ($x = 0; $x < $index; $x++) {

    echo "<tr><td>";
    echo $_SESSION['full_sched_array'][$x]->getFirstName() . " " .  $_SESSION['full_sched_array'][$x]->getLastName();
    echo "</td><td>";
    echo $_POST['total_' . $x];
    echo "</td><td>";
    echo convertTime($_POST['wed_time_start_'.$x],$_POST['wed_time_end_'.$x]);
    echo "</td><td>";
    echo convertTime($_POST['thu_time_start_'.$x],$_POST['thu_time_end_'.$x]);
    echo "</td><td>";
    echo convertTime($_POST['fri_time_start_'.$x],$_POST['fri_time_end_'.$x]);
    echo "</td><td>";
    echo convertTime($_POST['sat_time_start_'.$x],$_POST['sat_time_end_'.$x]);
    echo "</td><td>";
    echo convertTime($_POST['sun_time_start_'.$x],$_POST['sun_time_end_'.$x]);
    echo "</td><td>";
    echo convertTime($_POST['mon_time_start_'.$x],$_POST['mon_time_end_'.$x]);
    echo "</td><td>";
    echo convertTime($_POST['tue_time_start_'.$x],$_POST['tue_time_end_'.$x]);
    echo "</td></tr>";
}
echo "</table>";
?>
