<?php
    
    //This file still needs validation methods to make sure the submitted information is the correct format
    //I will work on that in the next couple of days. 

    //Include Employee php class file
    include_once 'Employee.php';
    
    //Start the session
    session_start();
    
    //Value to hold user update choice. 
    $update_choice = $_POST['update_choice'];
     
    //Variables that will be used as regular expressions to match to user input. 
    $name_match ="/^[A-Za-z]+$/";
    $email_match;
      
   //If the user tries to submit anything other than an Add employee command without selecting a valid employee. 
    //They are sent back into the manageEmployee.php page. 
    
    if($update_choice !== 'Add' && ($_POST['array_index']===null || $_POST['array_index']==='')){
       
        $_SESSION['no_employee_selected'] = "True";
        header("Location: manageEmployees.php");
    }
    
    else{
        
        //Variable used to know whether or not the user submitted a valid employee update. 
        $error_found = "False";
        
        $first = $_POST['first_name'];
        $last = $_POST['last_name'];
        $email = $_POST['email'];
        $type = $_POST['type'];
        $minor = $_POST['minor'];
       
        if($update_choice === 'Add'){
        
            if(!preg_match($name_match,$first)){
                
                $error_found = "True";
            }
            else if(!preg_match($name_match,$last)){
                
               $error_found = "True";
            }
            else{
                
                $error_found = "False";
            }
        }
    
        else if($update_choice === 'Update'){
        
            if(!preg_match($name_match,$first)){
                
                $error_found = "True";
            }
            else if(!preg_match($name_match,$last)){
                
               $error_found = "True";
            }
            else{
                
                $error_found = "False";
            }
        }
    
        else if($update_choice === 'Delete'){
        
            echo "Blah";
            $array_index = $_POST['array_index'];
            
             unset($_SESSION['employee_array'][$array_index]);
        }
    }
   
    if($error_found ==="False"){
        
        if($update_choice === 'Add'){
            
            $new_employee = new Employee;
            
            $new_employee->setEmployeeFirstName($first);
            $new_employee->setEmployeeLastName($last);
            $new_employee->setEmployeeEmail($email);
            $new_employee->setEmployeeType($type);
            $new_employee->setEmployeeMinor($minor);
            
            array_push($_SESSION['employee_array'],$new_employee);
            
            header("Location: manageEmployees.php");
        }
        
        else if($update_choice === 'Update'){
            
             //Assign the edited employee array index to a local variable
            $array_index = $_POST['array_index'];
    
            //Replace employee information with submitted edited information.
            $_SESSION['employee_array'][$array_index]->setEmployeeFirstName($first);
            $_SESSION['employee_array'][$array_index]->setEmployeeLastName($last);
            $_SESSION['employee_array'][$array_index]->setEmployeeEmail($email);
            $_SESSION['employee_array'][$array_index]->setEmployeeType($type);
            $_SESSION['employee_array'][$array_index]->setEmployeeMinor($minor);
    
            //Send the user back tot he manageEmployees.php file to see the updated employe data. 
            header("Location: manageEmployees.php");
        }
        else if($update_choice === 'Delete'){
            
            unset($_SESSION['employee_array'][$array_index]);
            
        }
        
        else{
            
            //Assign the edited employee array index to a local variable
            $array_index = $_POST['array_index'];
    
            //Replace employee information with submitted edited information.
            $_SESSION['employee_array'][$array_index]->setEmployeeFirstName($first);
            $_SESSION['employee_array'][$array_index]->setEmployeeLastName($last);
            $_SESSION['employee_array'][$array_index]->setEmployeeEmail($email);
            $_SESSION['employee_array'][$array_index]->setEmployeeType($type);
            $_SESSION['employee_array'][$array_index]->setEmployeeMinor($minor);
    
            //Send the user back tot he manageEmployees.php file to see the updated employe data. 
            header("Location: manageEmployees.php");
        }
    }
    
    else{
        
        header("Location: manageEmployees.php");
    }
?>
