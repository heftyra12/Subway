<?php
session_start();

echo "HelperFiles/validateEmployee.php";

$employee_id = $_POST['employee_id'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$type = $_POST['type'];
$minor = $_POST['minor'];
$index_value = $_POST['array_index'];
$update_choice = $_POST['update_option'];

//to match valid first and last names:
$name_match ="/^[A-Za-z]+$/";

//Check for modifying an employee without selecting one
if($update_choice !== 'Add' && ($index_value != 0 && empty($index_value))){
    
    $_SESSION['no_employee_selected'] = "true";
   
    header("Location:/ManageEmployee/index.php");
}

//Check for adding a duplicate employee
else if($update_choice === 'Add' && (!empty($index_value))){
  
    $_SESSION['duplicate_employee'] = "true";
    header("Location: /ManageEmployee/index.php");
}
else{
    
    $error_found = "false";
    
    if($update_choice === 'Add'){
        
        if(preg_match($name_match,$first_name)){
            
           if(preg_match($name_match,$last_name)){
               
               $error_found = "false";
           } 
           else
               $error_found = "true";
        }
        else
            $error_found = "true";
    }
    else{
        
        if($update_choice === 'Update'){
            
            if(preg_match($name_match,$first_name)){
                    
                if(preg_match($name_match,$last_name)){
                    
                    $error_found = "false";
                }
                
                else
                    $error_found = "true";
            }
            else
                $error_found = "true";
        }
        
        else{
            
            if($update_choice === 'Delete'){
                
                $error_found = "false";
                
            }
        }
    }
    
    if($error_found === "false"){
        
        $db_host = "localhost";
        $db_user = "root";
        $db_pass = "admin";
        $db_name = "test";

        $db_connect = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
        
        if($update_choice ==='Add'){
            
            $sql="INSERT INTO test.employees (first_name, last_name, email, type, minor)
                    VALUES('$first_name','$last_name','$email', '$type','$minor')";
            
            mysqli_query($db_connect,$sql);
            
            header("Location:/ManageEmployee/index.php");
        }
        
        else{
            
            if($update_choice ==='Update'){
                
                mysqli_query($db_connect,"UPDATE test.employees SET first_name ='$first_name', last_name ='$last_name',
                    email ='$email', type ='$type',minor='$minor' WHERE idemployees ='$employee_id'");
                
                header("Location:/ManageEmployee/index.php");
            }
            else{
                
                if($update_choice ==='Delete'){
                    
                    mysqli_query($db_connect,"DELETE FROM test.employees WHERE idemployees='$employee_id'");
                    
                    header("Location:/ManageEmployee/index.php");
                }
            }
        }
        
        
        
    }
    else{
        
        header("Location: /ManageEmployee/index.php");
    }
}    
?>
