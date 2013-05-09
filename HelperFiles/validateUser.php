<?php
    session_start();

    include_once'config.php';
 
    $user_name = filter_var($_POST['user_name'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
   
    if (mysqli_connect_errno()) {
        echo "DB connect error: %s\n", mysqli_connect_error();  
    }
  
    $loginSQL = 'SELECT user_name, password FROM subway.employee WHERE user_name="'. $user_name .'" and password="'.$password.'"';
    $result = mysqli_query($db_connect,$loginSQL);

    if (false === $result) 
        echo "DB fetch error: %s\n", mysqli_error($db_connect);
    
   $row = mysqli_fetch_array($result);

    if($user_name === $row["user_name"] && $password === $row["password"])
    {
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_password'] = $password;
        
        unset($_SESSION['user_name_error']);
        unset($_SESSION['password_error']);
            
        header("Location: /MainMenu/index.php");
    }
    else
    {    
        $_SESSION['user_name_error'] = "Error: Invalid Login";
        $_SESSION['password_error'] = "Error: Invalid Login";
    
        header("Location: /index.php");
    }
?>

