<?php

session_start();
include_once'config.php';
include_once'employeeClass.php';

$employee_id = $_POST['employee_id'];
$first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
$last_name = filter_var($_POST['last_name'], FILTER_SANITIZE_STRING);
$emp_type = $_POST['emp_type'];
$emp_minor = $_POST['emp_minor'];
$index_value = $_POST['array_index'];
$update_choice = $_POST['update_option'];
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
$_SESSION['type'] = $emp_type;
$_SESSION['minor'] = $emp_minor;

if ($update_choice !== 'Add' && ($index_value != 0 && empty($index_value))) 
{
    $_SESSION['no_employee_selected'] = "true";
    header("Location: /ManageEmployee/index.php");
} 
else if ($update_choice === 'Add' && (!empty($index_value))){

    $_SESSION['duplicate_employee'] = "true";
    header("Location: /ManageEmployee/index.php");
} 
else if($emp_type === 'Full-Time' && $emp_minor === 'Yes'){
    
    $_SESSION['fulltime_minor'] = "true";
    header("Location: /ManageEmployee/index.php");
}
else 
{
    $error_found = "false";

    if ($update_choice === 'Add' || $update_choice === 'Update')
    {
        if ($first_name =="")
        {
            $error_found = "true";
            $_SESSION['first_name'] = "Error: Invalid First Name";
        }
        if ($last_name == "") 
        {
            $error_found = "true";
            $_SESSION['last_name'] = "Error: Invalid Last Name:";
        } 
        else 
        {
            if($update_choice === 'Delete') 
            {
                $error_found = "false";
            }
        }
    }

    if($error_found === "false")
    {    
        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        unset($_SESSION['email']);
        unset($_SESSION['type']);
        unset($_SESSION['minor']);

        $total_emp = count($_SESSION['employee_array']) - 1;
        
        $sqlCommand = "select max(employee_id)as val from subway.employee";
        $result = mysqli_query($db_connect, $sqlCommand);
        
        while ($row = mysqli_fetch_array($result))
        {
            $add_count=$row["val"]+1;
        }
        
        $store_id=1;
        
        // replace html values with db appropriate values:
        $mon_start=str_replace('default', 'null', $mon_start);
        $mon_end=str_replace("\0", 'null', $mon_end);
        $tues_start=str_replace('default', 'null', $tues_start);
        $tues_end=preg_replace("/^[0-9]?$/", 'null', $tues_end);
        $wed_start=str_replace('default', 'null', $wed_start);
        $wed_end=preg_replace("/^[0-9]?$/", 'null', $wed_end);
        $thurs_start=str_replace('default', 'null', $thurs_start);
        $thurs_end=preg_replace("/^[0-9]?$/", 'null', $thurs_end);
        $fri_start=str_replace('default', 'null', $fri_start);
        $fri_end=preg_replace("/^[0-9]?$/", 'null', $fri_end);
        $sat_start=str_replace('default', 'null', $sat_start);
        $sat_end=preg_replace("/^[0-9]?$/", 'null', $sat_end);
        $sun_start=str_replace('default', 'null', $sun_start);
        $sun_end=preg_replace("/^[0-9]?$/", 'null', $sun_end);

        $addEmployeeSQL = "INSERT INTO subway.employee VALUES 
            ($add_count, $store_id, concat(substring(lower('$first_name'),1,3),$add_count), concat(substring(lower('$first_name'),1,3),$add_count), '$first_name', '$last_name', '$email', '$emp_type', '$emp_minor',
            $mon_start, $mon_end, $tues_start, $tues_end, $wed_start, $wed_end, $thurs_start, $thurs_end, $fri_start, $fri_end,
            $sat_start, $sat_end, $sun_start, $sun_end)";
        
        $updateEmployeeSQL = "UPDATE subway.employee SET first_name ='$first_name', last_name ='$last_name', email ='$email', emp_type ='$emp_type', 
            emp_minor='$emp_minor', monday_start=$mon_start, monday_end=$mon_end, tuesday_start=$tues_start, tuesday_end=$tues_end,
            wednesday_start=$wed_start, wednesday_end=$wed_end, thursday_start=$thurs_start, thursday_end=$thurs_end, 
            friday_start=$fri_start, friday_end=$fri_end, saturday_start=$sat_start, sunday_start=$sun_start, sunday_end=$sun_end
            WHERE employee_id =$employee_id";

        if ($update_choice === 'Add')
        {
            mysqli_query($db_connect, $addEmployeeSQL);
            header("Location:/ManageEmployee/index.php");
        } 
        else
        {
            if ($update_choice === 'Update')
            {
                mysqli_query($db_connect, $updateEmployeeSQL);
                header("Location:/ManageEmployee/index.php");
            }
            else
            {
                if ($update_choice === 'Delete')
                {
                    mysqli_query($db_connect, "DELETE FROM subway.employee WHERE employee_id='$employee_id'");
                    header("Location:/ManageEmployee/index.php");
                }
            }
       }
    } 
    else
    {
        $_SESSION['error_found'] = $error_found;
        header("Location: /ManageEmployee/index.php");
    }
}
?>