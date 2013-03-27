<?php

include_once'config.php';
include_once'employeeClass.php';

session_start();

$employee_id = $_POST['employee_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$type = $_POST['type'];
$minor = $_POST['minor'];
$index_value = $_POST['array_index'];
$update_choice = $_POST['update_option'];
$count = count($_SESSION['employee_array']);
$mon_start = $_POST['monday_start'];
$mon_end = $_POST['monday_end'];
$tues_start = $_POST['tuesday_start'];
$tues_end = $_POST['tuesday_end'];
$wed_start = $_POST['wednesday_start'];
$wed_end = $_POST['wednesday_end'];
$thurs_start = $_POST['thursday_start'];
$thurs_end = $_POST['thursday_end'];
$fri_start = $_POST['friday_start'];
$fri_end = $_POST['friday_end'];
$sat_start = $_POST['saturday_start'];
$sat_end = $_POST['saturday_end'];
$sun_start = $_POST['sunday_start'];
$sun_end = $_POST['sunday_end'];

$_SESSION['first_name'] = $first_name;
$_SESSION['last_name'] = $last_name;
$_SESSION['email'] = $email;
$_SESSION['type'] = $type;
$_SESSION['minor'] = $minor;

//to match valid first and last names:
$name_match = "/^[A-Za-z]+$/";

if ($update_choice !== 'Add' && ($index_value != 0 && empty($index_value))) {

    $_SESSION['no_employee_selected'] = "true";
    header("Location: /ManageEmployee/index.php");
} 
else if ($update_choice === 'Add' && (!empty($index_value))) {

    $_SESSION['duplicate_employee'] = "true";
    header("Location: /ManageEmployee/index.php");
} 
else if($type === 'Full-Time' && $minor === 'Yes'){
    
    $_SESSION['fulltime_minor'] = "true";
    header("Location: /ManageEmployee/index.php");
}
else {

    $error_found = "false";

    if ($update_choice === 'Add' || $update_choice === 'Update') {

        if (!preg_match($name_match, $first_name)) {

            $error_found = "Error: Invalid First Name";
            $_SESSION['first_name'] = "Error: Invalid First Name";
        }
        if (!preg_match($name_match, $last_name)) {

            $error_found = "true";
            $_SESSION['last_name'] = "Error: Invalid Last Name:";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_found = "true";
            $_SESSION['email'] = "Error: Invalid Email Address:";
        } else {
            if ($update_choice === 'Delete') {
                $error_found = "false";
            }
        }
    }

    if ($error_found === "false") {

        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        unset($_SESSION['email']);
        unset($_SESSION['type']);
        unset($_SESSION['minor']);

        $total_emp = count($_SESSION['employee_array']) - 1;
        $last_id = $_SESSION['employee_array'][($total_emp)]->getEmployeeID();
        $add_count = $last_id + 1;

        $addScheduleSQL = "INSERT INTO test.schedule(idschedule,monday_start,tuesday_start, wednesday_start, thursday_start, friday_start, saturday_start, sunday_start,
                 monday_end, tuesday_end, wednesday_end, thursday_end, friday_end, saturday_end, sunday_end) VALUES('$add_count','$mon_start', '$tues_start', '$wed_start',
                     '$thurs_start', '$fri_start', '$sat_start', '$sun_start', '$mon_end', '$tues_end', '$wed_end', '$thurs_end', '$fri_end', '$sat_end',
                         '$sun_end')";

        $addEmployeeSQL = "INSERT INTO test.emp(idemp,first_name, last_name, email, type, minor)
                    VALUES('$add_count','$first_name','$last_name','$email','$type','$minor')";

        $updateEmployeeSQL = "UPDATE test.emp SET first_name ='$first_name', last_name ='$last_name',
                    email ='$email', type ='$type', minor='$minor' WHERE idemp ='$employee_id'";

        $updateScheduleSQL = "UPDATE test.schedule SET monday_start ='$mon_start', monday_end ='$mon_end', tuesday_start ='$tues_start', tuesday_end ='$tues_end',
                    wednesday_start ='$wed_start' , wednesday_end ='$wed_end' , thursday_start ='$thurs_start' , thursday_end ='$thurs_end' , friday_start='$fri_start' ,
                        friday_end='$fri_end', saturday_start ='$sat_start', saturday_end ='$sat_end', sunday_start='$sun_start',sunday_end='$sun_end' 
                            WHERE idschedule ='$employee_id'";

        if ($update_choice === 'Add') {

            mysqli_query($db_connect, $addEmployeeSQL);
            mysqli_query($db_connect, $addScheduleSQL);
            header("Location:/ManageEmployee/index.php");
        } else {

            if ($update_choice === 'Update') {
                mysqli_query($db_connect, $updateEmployeeSQL);
                mysqli_query($db_connect, $updateScheduleSQL);
                header("Location:/ManageEmployee/index.php");
            } else {

                if ($update_choice === 'Delete') {
                    mysqli_query($db_connect, "DELETE FROM test.emp WHERE idemp='$employee_id'");
                    mysqli_query($db_connect, "DELETE FROM test.schedule WHERE idschedule ='$employee_id'");
                    header("Location:/ManageEmployee/index.php");
                }
            }
        }
    } else {
        $_SESSION['error_found'] = $error_found;
        header("Location: /ManageEmployee/index.php");
    }
}
?>
