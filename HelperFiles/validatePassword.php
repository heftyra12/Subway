<?php
session_start();
include_once'config.php';

$user_name = $_SESSION['user_name'];
$password = $_SESSION['user_password'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$new_password_again = $_POST['new_password_again'];

if($current_password !== $password){
    
    $_SESSION['current_error'] = "yes";
    header("Location:/MainMenu/changePassword.php");
}

if($new_password !== $new_password_again){
    
    $_SESSION['new_password_error'] = "yes";
    header("Location:/MainMenu/changePassword.php");
}

else if(($current_password === $password)&&($new_password === $new_password_again)){
    
    $updatePasswordSQL = "UPDATE test.login SET password ='$new_password' WHERE user_name ='$user_name'";
   
    mysqli_query($db_connect,$updatePasswordSQL);
    
    $_SESSION['password_change_success'] ="yes";
   
    header("Location: /MainMenu/index.php");
}
?>
