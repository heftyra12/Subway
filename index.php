<?php
    //Start initial session
    session_start();

    //If $_POST['exit'] is set and equal to destroy destroy session
    //and start a new session. 
    if(isset($_POST['exit'])){
       if($_POST['exit'] === "destroy"){
            session_destroy();
            session_start();
       }
    }
    
    if(!isset($_SESSION['user_name_error']))
        $_SESSION['user_name_error'] = '';
	
    if(!isset($_SESSION['password_error']))
        $_SESSION['password_error'] = ''; 
    
    if(isset($_SESSION['no_product']))
        unset($_SESSION['no_product']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="shortcut icon" href="../images/subway.ico">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <title></title>
        <!--Place cursor in the username field:-->
        <script language="javascript" type="text/javascript">
        function placefocus()
        {
            document.loginform.user_name.focus();
        }
        </script> 
    </head>
    <body background="/Images/test_background.png" onLoad="placefocus()">
    	       
        <div id="login_div">
            
            <div id="logo_holder">
                <img src="Images/login_v2.jpg" style="padding-left:55px;padding-top:20px;">
            </div>
            </br>
            <div id="form_div" background-color="yellow">
                <form action = "/HelperFiles/validateUser.php" method = "POST" align="left" name="loginform">
    			User Name: <input type="text" name="user_name" value ="<?php echo $_SESSION['user_name_error'];?>" autocomplete="off" required/></br>

                        </br>
                        Password: <input type="password" name="password" value="<?php echo $_SESSION['password_error'];?>" autocomplete ="off" required/></br></br>
    			<input type="submit" value="Log In:"/>	
    		</form>
            </div>
        </div>
    </body>
</html>

