<?php
    
    session_start();
    
    echo "<link rel='stylesheet' href='subway_css.css' type='text/css'>";
    
    echo "<table>";
    echo "<tr><th><h2>main menu</h2></th></tr>";
    echo "<form action ='control.php' method='POST'>";
    
    echo "<tr><td><select id='user_choice' name='user_choice'>";
    echo "<option>Manage Schedule</option>";
    echo "<option>View Schedule</option>";
    echo "<option>Edit Requests</option>";
    echo "<option>Manage Employees</option>";
    echo "<option>Scheduling Parameters</option>";
    echo "</select></td></tr>";
    echo "<tr><td><input type='submit' value='Select Option'></td></tr>";
    echo "</form>";
    echo "</table>";
    
    
?>
