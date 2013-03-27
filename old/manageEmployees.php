<?php
    
    //Include the Employee php class file.
    include_once 'Employee.php';

    //Start the session.
    session_start();

    //Include the css file.
    echo "<link rel='stylesheet' href='subway_css.css' type='text/css'>";
    
    //If the employee array session object hasn't been set enter this if statement to assign 
    //employees(Will change once we get the database working). 
    echo"hola";
    if(!isset($_SESSION['employee_array'])){
        
        //Array to hold employee objects    
        $employee_array = array();
    
        //Assign values for each employee
        $dbConn = mysqli_connect("localhost", "root", "admin","subway");
        $sqlCommand = 'select first_name, last_name, email, emp_type, emp_minor from subway.employee';
        $result = mysqli_query($dbConn, $sqlCommand);

        if (false === $result) 
            echo "DB fetch error: %s\n", mysqli_error($dbConn);
        $num_rows =  mysql_num_rows($result);
        $row = mysqli_fetch_array($result);
        
        //Put employee objects into the array. 
        for($x=0;$x<=$num_rows;$x++){
            $new_employee = new Employee;
            array_push($employee_array,$new_employee);
        }
        
        for ($x=1; $x<=$num_rows; $x++){
            $employee_array[$x]->setEmployeeLastName($row["last_name"]);
            $employee_array[$x]->setEmployeeEmail($row["email"]);
            $employee_array[$x]->setEmployeeType($row["emp_type"]);
            $employee_array[$x]->setEmployeeMinor($row["emp_minor"]);
        }
        echo"hi";
        /*while($row = mysqli_fetch_array($result)){
            $dbName = $row["user_name"];
            $dbPass = $row["password"];
        }*/
        /*$employee_array[0]->setEmployeeFirstName("Troy");
        $employee_array[0]->setEmployeeLastName("Halverson");
        $employee_array[0]->setEmployeeEmail("halversotm30@uww.edu");
        $employee_array[0]->setEmployeeType("Full-ime");
        $employee_array[0]->setEmployeeMinor("No");
    
        $employee_array[1]->setEmployeeFirstName("Rob");
        $employee_array[1]->setEmployeeLastName("Hefty");
        $employee_array[1]->setEmployeeEmail("test10@uww.edu");
        $employee_array[1]->setEmployeeType("Full-Time");
        $employee_array[1]->setEmployeeMinor("No");
    
        $employee_array[2]->setEmployeeFirstName("Katherine");
        $employee_array[2]->setEmployeeLastName("Travis");
        $employee_array[2]->setEmployeeEmail("test2@uww.edu");
        $employee_array[2]->setEmployeeType("Full-Time");
        $employee_array[2]->setEmployeeMinor("No");
    
        $employee_array[3]->setEmployeeFirstName("Nicki");
        $employee_array[3]->setEmployeeLastName("Edwards");
        $employee_array[3]->setEmployeeEmail("test3.edu");
        $employee_array[3]->setEmployeeType("Full-Time");
        $employee_array[3]->setEmployeeMinor("No");
    
        $employee_array[4]->setEmployeeFirstName("Temp");
        $employee_array[4]->setEmployeeLastName("Employee");
        $employee_array[4]->setEmployeeEmail("temp4@uww.edu");
        $employee_array[4]->setEmployeeType("Part-Time");
        $employee_array[4]->setEmployeeMinor("Yes");*/
     
        //Assign $employee_array array to a session object. 
        $_SESSION['employee_array'] = $employee_array;
    }
    
    //If the user submits an update or delete command without selecting an employee from the list. I figure 
    //this will make it less likely that there is an input error. If we decide this is not needed it can easily 
    //be taken out. 
    if($_SESSION['no_employee_selected']==="True"){
         
        //Echo a JS alert to inform user. 
        echo "<script language=javascript>alert('Please select an employee to modify')</script>";
        $_SESSION['no_employee_selected'] = "False";
    }
    
    echo "<table>";
    echo "<tr><th><h2>Manage Employees</h2></th></tr>";
    echo "<form action='validateUpdate.php' method='POST'>";
    
    //These three fields are made required, so the user cannot submit a blank employee form. 
    echo "<tr><td>First Name: <input type='text' name='first_name' id='first_name'value='' required></td></tr>";
    echo "<tr><td>Last Name: <input type='text' name='last_name' id='last_name'value='' required></td></tr>";
    echo "<tr><td>Email: <input type='text' name='email' id='email'value='' required></td></tr>";
    
    //Employee type dropdown box.
    echo "<tr><td>Employee Type: <select id='type' name='type'>";
    echo "<option value ='Full-Time'>Full-Time</option>";
    echo "<option value ='Part-Time'>Part-Time</option>";
    echo "</select>";
    
    //Employee minor dropdown box. 
    echo "<tr><td>Minor: <select id='minor' name='minor'>";
    echo "<option value ='Yes'>Yes</option>";
    echo "<option value ='No'>No</option>";
    echo "</select></td></tr>";
    
    //Hidden field to keep track of which array_index the user in modifying
    echo "<input type='hidden' id='array_index' name = 'array_index'/>";
    echo "<tr><td>";
    
    //Select for the user to decide if they want to add, update, or delete an employee. 
    echo "<select name ='update_choice' id='update_choice'>";
    echo "<option value='Add'>Add</option>";
    echo "<option value='Update'>Update</option>";
    echo "<option value='Delete'>Delete</option>";
    echo "</select>";
    echo "<input type='submit' value='Submit'>"; 
    echo "</form>";
    
    echo "</td></tr>";
    echo "<tr><td>";
    
    //Nested form to take the user back to the main menu if they wish. 
    echo "<form action ='mainMenu.php' method ='POST'>";
    echo "<input type ='submit' value='Main Menu'></td></tr>";
    echo "</form>";
    echo "</table>";
    
    //Table of existing employees
    echo "<table>";
    echo "<tr><h2><th></th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Type</th><th>Minor</th></h2></tr>";
  
    for($x=0;$x<count($_SESSION['employee_array']);$x++){
        
        $first = $_SESSION['employee_array'][$x]->getEmployeeFirstName();
        $last = $_SESSION['employee_array'][$x]->getEmployeeLastName();
        $email = $_SESSION['employee_array'][$x]->getEmployeeEmail();
        $type = $_SESSION['employee_array'][$x]->getEmployeeType();
        $minor = $_SESSION['employee_array'][$x]->getEmployeeMinor();
     
        echo"<tr><td><input type='radio' id='employee' name='employee' onclick = 'insertEmployee($x,\"$first\",\"$last\",\"$email\",\"$minor\",\"$type\")'
            value=''></td>";
        echo "<td>";
        echo $first."  ";
        echo "</td><td>";
        echo $last."  ";
        echo "</td><td>";
        echo $email."  ";
        echo "</td><td>";
        echo $type."  ";
        echo "</td><td>";
        echo $minor."  ";
        echo"</td></tr>";
    }
    echo "</table>";  
?>

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
       document.getElementById('')
       document.getElementById('emp_minor').value =minor;
       document.getElementById('emp_type').value = type;
       document.getElementById('array_index').value = array_index;
   }
</script>
