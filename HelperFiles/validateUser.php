<?php
  session_start();

    include_once'config.php';
//Start session
  
    
    
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    
    $dbName ="";
    $dbPass ="";
    
    //Call the validateUser function.
    $stripped_name = validateUser($user_name);
    $stripped_password = validateUser($password);    
     
    function validateUser($user_info){
    
        //Variables to hold the user's login information
        $temp_info = "";
        $user_input = $user_info;
        
       //For loop to go through each character of the user's login information
        for($x=0; $x<strlen($user_input);$x++){
            
            switch($user_info[$x]){
                
                case'(': $temp_info.="";
                    break;
                case')': $temp_info.="";
                    break;
                case'<': $temp_info.="";
                    break;
                case'>': $temp_info.="";
                    break;
                case';': $temp_info.="";
                    break;
                case'"': $temp_info.="";
                    break;
                case'&': $temp_info.="";
                    break;
                case'@': $temp_info.='';
                    break;
                default: $temp_info.=$user_info[$x];
            }
        }
        return $temp_info;
    }
    
    if (mysqli_connect_errno()) {
        echo "DB connect error: %s\n", mysqli_connect_error();  
    }
    
    
    $loginSQL = 'SELECT user_name, password FROM subway.employee WHERE user_name="'.$stripped_name.'" and password="'.$stripped_password.'"';
    $result = mysqli_query($db_connect,$loginSQL);

    if (false === $result) 
        echo "DB fetch error: %s\n", mysqli_error($db_connect);
    
    while($row = mysqli_fetch_array($result)){
        $dbName = $row["user_name"];
        $dbPass = $row["password"];
    }

    /*$sqlCommand = "update test.employee set name=boyeah where employee_id=1";
    $query = mysqli_query($con, $sqlCommand);*/
    
    if($stripped_name === $dbName && $stripped_password === $dbPass){
        $_SESSION['user_name'] = $stripped_name;
        $_SESSION['user_password'] = $stripped_password;
        
        unset($_SESSION['user_name_error']);
        unset($_SESSION['password_error']);
            
        header("Location: /MainMenu/index.php");
    }
    else{
        
        if($stripped_name !== $dbName || $stripped_password !== $dbPass){
            $_SESSION['user_name_error'] = "Error: Invalid Log in ";
            $_SESSION['password_error'] = "Error: Invalid Log in";
        }
          
        header("Location: /index.php");
    }
?>

