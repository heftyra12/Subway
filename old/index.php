<?php
include_once 'employeeClass.php';

session_start();


$db_host = "localhost";
$db_user = "root";
$db_pass = "admin";
$db_name = "test";

$db_connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);


$sqlCommand = 'SELECT first_name,last_name,email,type,minor FROM test.employees';

$result = mysqli_query($db_connect, $sqlCommand);

$employee_array = array();

$x = 0;

while ($row = mysqli_fetch_array($result)) {

    $employee = new employeeClass;


    $employee->setEmployeeFirstName($row["first_name"]);
    $employee->setEmployeeLastName($row["last_name"]);
    $employee->setEmployeeEmail($row["email"]);
    $employee->setEmployeeType($row["type"]);
    $employee->setEmployeeMinor($row["minor"]);

    array_push($employee_array, $employee);
}

$_SESSION['employee_array'] = $employee_array;
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <title>Subway Scheduling Program: Manage Employees</title>
    </head>
    <body>

        <ul class="subway_tabs">
            <li><a href="/MainMenu/index.php">Welcome:</a></li>
            <li><a href="/ManageSchedule/index.php" id="schedule_tab" value ="manage_schedule">Manage Schedule</a></li>
            <li class="current_position">Manage Employees:</li>
            <li><a href="/EditRequests/index.php" value="edit_requests">Edit Requests:</a></li>
            <li><a href="/ViewSchedule/index.php">View Schedule:</a></li>
            <li><a href="/ScheduleParameters/index.php">Scheduling Parameters:</a></li>
        </ul>       

        <div id="employee_body">

            <div id="employee_update">
                <table>
                    <form action="/HelperFiles/validateEmployee.php" method="POST">

                        <tr><td>First Name:<input type="text" id="first_name" name="first_name" value="" required/></td></tr>
                        <tr><td>Last Name:<input type="text" id="last_name" name="last_name" value=""required/></td></tr>
                        <tr><td>Email:<input type="text" id="email" name="email" value="" required/></td></tr>
                        <tr><td>Type: <select id="employee_type" name="type"/>
                        <option value="Full-Time">Full-Time</option>
                        <option value="Part-Time">Part-Time</option>
                        </select></td><tr>
                        <tr><td>Minor: <select id="minor" name="minor"/>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        </select></td></tr>
                        <tr><td>Action: <select id="update_option" name="update_option"/>
                        <option value="Add">Add</option>
                        <option value="Update">Update</option>
                        <option value="Delete">Delete</option>
                        </select></td></tr>
                        <tr><td><input type="submit" value="Submit"/></td></tr>
                    </form>
                </table>
            </div>
            <div id="existing_employees">
                <table>
                    <form>

                        <tr><th colspan="7"><h2>Subway Employees</h2></th></tr>
                        
                        <?php
                        for ($x = 0; $x < count($employee_array); $x++) {

                            $first = $_SESSION['employee_array'][$x]->getEmployeeFirstName();
                            $last = $_SESSION['employee_array'][$x]->getEmployeeLastName();
                            $email = $_SESSION['employee_array'][$x]->getEmployeeEmail();
                            $type = $_SESSION['employee_array'][$x]->getEmployeeType();
                            $minor = $_SESSION['employee_array'][$x]->getEmployeeMinor();

                            echo"<tr><td><input type='radio' id='employee' name='employee' 
                                onclick = 'insertEmployee($x,\"$first\",\"$last\",\"$email\",\"$minor\",\"$type\")'value=''></td>";
                            echo "<td>";
                            echo $first . "  ";
                            echo "</td><td>";
                            echo $last . "  ";
                            echo "</td><td>";
                            echo $email . "  ";
                            echo "</td><td>";
                            echo $type . "  ";
                            echo "</td><td>";
                            echo $minor . "  ";
                            echo"</td></tr>";
                        }
                        ?>
                    </form>
                </table>
            </div>

        </div>
    </body>
</html>

<script language="Javascript">
   
    /*
     * The insertEmployee method will take the array index that the user selected along
     * with the first, last, email, minor, and type of that employee in the existing 
     * employee table. These values will then be inserted into the form that allows
     * the user to modify employees. This should lead to less input errors as the user
     * will only have to modify the fields that need modification. Everything else is 
     * plugged in for them. 
     */
    function insertEmployee(index,first,last,email,minor,type){
       
        //Variables to hold index, name, type, email, and if they are a minor. 
        var array_index = index; 
        var minor = minor;
        var type = type;
        var first_name = first;
        var last_name = last; 
        var emp_email = email;
       
        //Assign values to form fields. 
        document.getElementById('first_name').value = first_name;
        document.getElementById('last_name').value = last_name;
        document.getElementById('email').value = email;
        document.getElementById('minor').value =minor;
        document.getElementById('employee_type').value = type;
        document.getElementById('array_index').value = array_index;
    }
</script>

