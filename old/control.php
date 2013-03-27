<?php

    session_start();
    
    $user_selection = $_POST['user_choice'];
   
    
    if($user_selection === "Manage Schedule")
        header("Location: manageSchedule.php");
    else if($user_selection === "Manage Employees")
        header("Location: manageEmployees.php");
    else if($user_selection === "View Schedule")
        header("Location: viewSchedule.php");
    else if($user_selection === "Schedule Parameters")
        header("Location: scheduleParameters.php");
    else
        header("Location: editRequest.php");
    
    
?>
