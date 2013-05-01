<?php
session_start();

include_once'config.php';
include_once'employeeClass.php';

$employee_id = $_POST['employee_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$emp_type = $_POST['emp_type'];
$emp_minor = $_POST['emp_minor'];
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
$_SESSION['emp_type'] = $emp_type;
$_SESSION['emp_minor'] = $emp_minor;

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
else if($emp_type === 'F' && $emp_minor === 'Y'){
    
    $_SESSION['fulltime_minor'] = "true";
    header("Location: /ManageEmployee/index.php");
}
else {

    $error_found = "false";
// validate name values;
    if ($update_choice === 'Add' || $update_choice === 'Update') {

        if (!preg_match($name_match, $first_name)) {

            $error_found = "Error: Invalid First Name";
            $_SESSION['first_name'] = "Error: Invalid First Name";
        }
        if (!preg_match($name_match, $last_name)) {

            $error_found = "true";
            $_SESSION['last_name'] = "Error: Invalid Last Name:";
        }
    }

    if ($error_found === "false") {

        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        unset($_SESSION['emp_type']);
        unset($_SESSION['emp_minor']);

        $total_emp = count($_SESSION['employee_array']) - 1;
        // $last_id = $_SESSION['employee_array'][($total_emp)]->getEmployeeID();

        //$add_count = $last_id + 1;
        $result = mysqli_query($db_connect, "select max(employee_id)+1 as count from subway.employee");
        while($row = mysqli_fetch_array($result)){
            $add_count = $row["count"];
        }
        // create generic username as lastname+max employee id;
        $user_name = strtolower($last_name."".$add_count);
        // set default password to a value that can't even login;
        // probably a much better way to do these next two, but oh well;
        $password = ' ';
        $store_id = 1;

        $addEmployeeSQL = "INSERT INTO subway.employee(employee_id,store_id, user_name, password, 
            first_name, last_name, emp_type, emp_minor, monday_start, tuesday_start, wednesday_start, 
            thursday_start, friday_start, saturday_start, sunday_start, monday_end, 
            tuesday_end, wednesday_end, thursday_end, friday_end, saturday_end, sunday_end) VALUES
            ('$add_count','$store_id','$user_name','$password','$first_name','$last_name',
            ''$emp_type', '$emp_minor', '$mon_start', '$tues_start', '$wed_start',
            '$thurs_start', '$fri_start', '$sat_start', '$sun_start', '$mon_end', 
            '$tues_end', '$wed_end', '$thurs_end', '$fri_end', '$sat_end','$sun_end')";
        $addEmployeeSQL = str_replace("''",'null',$addEmployeeSQL);

        $updateEmployeeSQL = "UPDATE subway.employee SET first_name ='$first_name',
            last_name ='$last_name', emp_type ='$emp_type', 
            emp_minor='$emp_minor', monday_start ='$mon_start', monday_end ='$mon_end', 
            tuesday_start ='$tues_start', tuesday_end ='$tues_end',
            wednesday_start ='$wed_start' , wednesday_end ='$wed_end',
            thursday_start ='$thurs_start' , thursday_end ='$thurs_end',
            friday_start='$fri_start' ,friday_end='$fri_end', saturday_start ='$sat_start',
            saturday_end ='$sat_end',sunday_start='$sun_start',sunday_end='$sun_end'
            WHERE employee_id ='$employee_id'";
        $updateEmployeeSQL = str_replace("''",'null',$updateEmployeeSQL);

        if ($update_choice === 'Add') {
            mysqli_query($db_connect, $addEmployeeSQL);
            header("Location:/ManageEmployee/index.php");
        } else {
            if ($update_choice === 'Update') {
                mysqli_query($db_connect, $updateEmployeeSQL);
                header("Location:/ManageEmployee/index.php");
            } else {
                if ($update_choice === 'Delete') {
                    mysqli_query($db_connect, "DELETE FROM subway.employee 
                        WHERE employee_id ='$employee_id'");
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