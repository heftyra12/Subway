<?php
session_start();

include_once'../../Subway/HelperFiles/config.php';
include_once'../../Subway/HelperFiles/employeeClass.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

if(isset($_SESSION['no_product']))
    unset($_SESSION['no_product']);


$sqlCommand = "SELECT idemp, first_name, last_name from test.emp";
$result = mysqli_query($db_connect, $sqlCommand);
$schedule_array = array();

while ($row = mysqli_fetch_array($result)) {

    $employee = new employeeClass;

    $employee->setEmployeeID($row["idemp"]);
    $employee->setEmployeeFirstName($row["first_name"]);
    $employee->setEmployeeLastName($row["last_name"]);
    array_push($schedule_array, $employee);
}

$_SESSION['schedule_array'] = $schedule_array;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <title>Subway Scheduling Program: Main Menu</title>
    </head>
    <body>
        <div id="page_top">
            <div id="top_image">
                <img src="/Images/temp_top_logo_3.png" align="center">
            </div>

            <ul class="subway_tabs">
                <li class="current_position">Home:</li>
                <li><a href="/ManageSchedule/index.php">Create Schedule</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule:</a></li>
                <li><a href="/ManageEmployee/index.php">Employees:</a></li>
                <li><a href="/EditRequests/index.php" >Requests:</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules:</a></li>
            </ul>       

            <div id="tab_bar"></div>

            <div id="normal_body">
                <div id="normal_left">

                    <form action="changePassword.php" >
                        <input type="submit" value ="Change Password"> 
                    </form>
                    </br>
                    </br>
                    <form action="/index.php" method="POST">
                        <input type="hidden" id="exit" name="exit" value="destroy">
                        <input type="submit" value="Exit">
                    </form>

                </div>

                <div id="normal_right">

                    <?php
                    
                        if(isset($_SESSION['password_change_success']))
                            
                            if($_SESSION['password_change_success']==="yes"){
                                
                                //Tell user password change was successful
                                echo "<script language = javascript>alert('Password Change Successful');</script>";
                                unset($_SESSION['password_change_success']);
                                
                                //If either of the password change error fiedls are set, unset them. 
                                if(isset($_SESSION['current_password_error']))
                                    unset($_SESSION['current_password_error']);
                                if(isset($_SESSION['new_password_error']))
                                    unset($_SESSION['new_password_error']);
                            }
                    ?>
                    
                    <div id="home_title">This Week's Schedule</div>
                    <div id="home_sched">
                        <table>
                            <tr><th>Employee:</th><th>Wednesday:</th><th>Thursday:</th><th>Friday:</th><th>Saturday:</th>
                                <th>Sunday:</th><th>Monday:</th><th>Tuesday:</th><th>Total Hours:</th></tr> 

                            </br>   

                            <?php
                            for ($x = 0; $x < count($_SESSION['schedule_array']); $x++) {

                                echo "<tr><td class='sched_emp'>";
                                echo $_SESSION['schedule_array'][$x]->getEmployeeFirstName() . " ";
                                echo $_SESSION['schedule_array'][$x]->getEmployeeLastName() . " </td>";
                                echo "<td><p class='generate_text_field'></p></td>";
                                echo "<td><p class='generate_text_field'></p></td>";
                                echo "<td><p class='generate_text_field'></p></td>";
                                echo "<td><p class='generate_text_field'></p></td>";
                                echo "<td><p class='generate_text_field'></p></td>";
                                echo "<td><p class='generate_text_field'></p></td>";
                                echo "<td><p class='generate_text_field'></p></td>";
                                echo "<td><p class='generate_text_field'></p></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>    
                </div>
            </div>
        </div>
    </body>
</html>


