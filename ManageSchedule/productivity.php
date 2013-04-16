<?php
session_start();

date_default_timezone_set('America/Chicago');

include_once'../HelperFiles/config.php';
include_once'../HelperFiles/productivityClass.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

$prodSQLCommand = 'SELECT store_id, week_no, units FROM subway.productivity';
$result = mysqli_query($db_connect,$prodSQLCommand);

$new_prod = new productivityClass;
$prod_array = array();
$day_array = array();

$day = 0;

while($row = mysqli_fetch_array($result)){
                
    $new_prod->setStoreNumber($row['store_id']);
    $new_prod->setWeekNumber($row['week_no']);
    array_push($day_array,$row['units']);
            
    if($day ==6){
        $new_prod->setAllProd($day_array);
        array_push($prod_array,$new_prod);
         $day =0;  
         $day_array = array();
        $new_prod = new productivityClass;
    }
    else{
        $day++;
    }
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>
        <title></title>
    </head>
    <body>

        <div id="page_top">

            <div id="top_image">
                <img src="/Images/temp_top_logo_3.png" id="image" align="center">
            </div>

            <ul class="subway_tabs">
                <li><a href="/MainMenu/index.php">Home</a></li>
                <li class="current_position">Create Schedule</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule</a></li>
                <li><a href="/ManageEmployee/index.php">Employees</a></li>
                <li><a href="/EditRequests/index.php">Requests</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules</a></li>
            </ul>     

            <div id="tab_bar"></div>
            
            <div id="small_body">

                <div id="small_left">
                    
                    <div id="left_buttons">
                        <form action="index.php" method="POST">
                            <input type="submit" value="Generate Schedule" class="subway_buttons"/>
                        </form>
                        <br/>
                        <br/>
                        <form action="shifts.php" method="POST">
                            <input type="submit" value="Schedule Shifts" class="subway_buttons"/>
                        </form>
                    </div>
                </div>

                <div id="small_right">
                    <div id="prod_table">
                    <form action="/HelperFiles/validateProductivity.php" method="POST">
                        <table style="text-align:right">
                            <tr><th id="table_title" colspan="9">Enter Productivity:</th></tr>
                            <tr><th>Week:</th>
                                <th>Wednesday</th>
                                <th>Thursday</th>
                                <th>Friday</th>
                                <th>Saturday</th>
                                <th>Sunday</th>
                                <th>Monday</th>
                                <th>Tuesday</th>
                            </tr>
                            <tr>
                                        <?php
                                           echo "<td><select name='week_list' id='week_list' onChange='updateChoice();'>";  
                                           echo "<option>---</option>";
                                           
                                           $newest_week = $_SESSION['current_week'];
                                           
                                           if($_SESSION['current_prod']==true){
                                            
                                               for($x=0;$x<count($prod_array);$x++){
                                                   
                                                   if($prod_array[$x]->getWeekNumber() > $newest_week){
                                                       $newest_week = $prod_array[$x]->getWeekNumber();
                                                   }                    
                                               }
                                               
                                               $week_values = $newest_week;
                                               for($x=0;$x < 4; $x++){                                 
                                                   $week_values++;
                                                   echo "<option value='$week_values'>";
                                                   echo $week_values;
                                                   echo "</option>";
                                               }
                                           }
                                           else{
                                               echo "<option value='$newest_week'>$newest_week</option>";
                                               $_SESSION['current_prod']=true;
                                           }
     
                                        echo"</select>";
                                        echo "</td>";
                                        ?>
                                                         
                                <td><input type ="text" name="wed_prod" id="wed_prod" class="product_field" required></td>
                                <td><input type="text" name="thurs_prod" id="thurs_prod" class="product_field" required></td>
                                <td><input type="text" name="fri_prod" id="fri_prod" class="product_field" required></td>
                                <td><input type="text" name="sat_prod" id="sat_prod" class="product_field" required></td>
                                <td><input type="text" name="sun_prod" id="sun_prod" class="product_field" required></td>
                                <td><input type="text" name="mon_prod" id="mon_prod" class="product_field" required></td>
                                <td><input type="text" name="tues_prod" id="tues_prod" class ="product_field" required></td>
                            </tr>
                             
                                <input type='hidden' name='newest_week' id='newest_week' value='<?php echo $newest_week;?>'>;
                                <input type="hidden" id="productivity" name="productivity" value=""/>
                                <input type="hidden" id="generate" name="generate" value=""/>
                                <input type="hidden" id="edit" name="edit" value=""/>
                                <input type="hidden" id="current_week" name="current_week" value="<?php echo date("W");?>">
                                <input type="hidden" id="current_prod" name="current_prod" value="<?php echo $_SESSION['current_prod'];?>">
                            
                            <tr>
                                <th colspan="7" style="text-align:right;">Action Choice:</th>
                                <td><select id="update_choice" name="update_choice" onChange ="weekUpdate();">
                                    </select></td>
                            </tr>
                            <tr><td colspan="8"><input type="button" value="Reset" onclick="resetForm();"></td></tr>
                            <tr>
                                <td colspan="8">
                                    <input type="submit" value="Submit Productivity"/>
                                </td>
                            </tr>
                        </table>  
                    </form>
                    </div>
                    
                    <div id="prod_table">
                        <table>
                            <tr>
                                <th id="table_title" colspan="9">Productivity Numbers</th>
                            </tr>
                            <tr>
                                <td></td>
                                <th>Week:</td>
                                <th>Wednesday:</th>
                                <th>Thursday:</th>
                                <th>Friday:</th>
                                <th>Saturday:</th>
                                <th>Sunday:</th>
                                <th>Monday:</th>
                                <th>Tuesday:</th>
                                <input type="hidden" name="current_week" id="current_week" value="<?php echo date("W"); ?>">
                            </tr>
                            <?php
                            
                                for($x=0;$x<count($prod_array);$x++){
                                    
                                    $week_number = $prod_array[$x]->getWeekNumber();
                                    $wed_prod = $prod_array[$x]->getWedProd();
                                    $thurs_prod =$prod_array[$x]->getThursProd();
                                    $fri_prod = $prod_array[$x]->getFriProd();
                                    $sat_prod = $prod_array[$x]->getSatProd();
                                    $sun_prod = $prod_array[$x]->getSunProd();
                                    $mon_prod = $prod_array[$x]->getMonProd();
                                    $tues_prod = $prod_array[$x]->getTuesProd();
                                    
                                    if($prod_array[$x]->getWeekNumber() >= date("W")){
                                 
                                        echo "<tr><td>";
                                        echo "<input type='radio' name ='prod' id='prod' value ='' 
                                                onclick='insertProd($x,\"$week_number\",\"$wed_prod\",\"$thurs_prod\",
                                                \"$fri_prod\",\"$sat_prod\",\"$sun_prod\",\"$mon_prod\",\"$tues_prod\");'></td>";
                                        echo "<td>";
                                        echo $week_number;
                                        echo "</td><td>";
                                        echo $wed_prod;
                                        echo "</td><td>";
                                        echo $thurs_prod;
                                        echo "</td><td>";
                                        echo $fri_prod;
                                        echo "</td><td>";
                                        echo $sat_prod;
                                        echo "</td><td>";
                                        echo $sun_prod;
                                        echo "</td><td>";
                                        echo $mon_prod;
                                        echo "</td><td>";
                                        echo $tues_prod;
                                        echo "</td></tr>";
                                    }
                                }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>

<script language="Javascript">
    
    function resetForm(){
        
        document.getElementById('wed_prod').value = "";
        document.getElementById('thurs_prod').value = "";
        document.getElementById('fri_prod').value = ""; 
        document.getElementById('sat_prod').value = ""; 
        document.getElementById('sun_prod').value = "";
        document.getElementById('mon_prod').value = "";
        document.getElementById('tues_prod').value = "";
        document.getElementById('update_choice').options.length=0;
        
        var list = document.getElementsByName('prod');
        
        for(var x = 0; x < list.length; x++){
            
            if(list[x].checked == true)
                list[x].checked = false; 
        }
        
        var current_production = document.getElementById("current_prod").value;
        var current_week = document.getElementById("current_week").value;
        var newest_week = document.getElementById("newest_week").value;
        var week_list = document.getElementById("week_list");
        
        if(current_production == true){
            
            week_list.options.length = 0; 
            var option = document.createElement("Option");
            option.text ="---";
            week_list.options[0] = option; 
            
            for(var x = 1; x < 5; x++){
                newest_week++;
                var option = document.createElement("Option");
                option.value = newest_week;
                option.text = newest_week;
                week_list.options[x] = option;
            }
        }
        else{
            
            week_list.options.length = 0; 
            var option = document.createElement("Option");
            option.value = current_week;
            option.text = current_week;
            week_list.options[0]=option;
        }     
    }
    
    function insertProd(index,week_number, wed_prod,thurs_prod,fri_prod,sat_prod,sun_prod,mon_prod,tues_prod){

        var index = index;
        var week_number = week_number;
        
        document.getElementById('wed_prod').value = wed_prod;
        document.getElementById('thurs_prod').value = thurs_prod;
        document.getElementById('fri_prod').value = fri_prod; 
        document.getElementById('sat_prod').value = sat_prod; 
        document.getElementById('sun_prod').value = sun_prod;
        document.getElementById('mon_prod').value = mon_prod;
        document.getElementById('tues_prod').value = tues_prod;
     
        var week_list = document.getElementById("week_list");
        week_list.options.length = 0;
        
        var option = document.createElement("Option");
        option.text = week_number;
        option.value = week_number; 
        week_list.options[0] = option;
        
        var current_week = document.getElementById("current_week").value;
        
        var update_choice = document.getElementById("update_choice");
        update_choice.options.length = 0;
        
        if(week_number >= current_week){
            
            var option = document.createElement("Option");
            option.value = "Update";
            option.text = "Update";
            update_choice.options[0] = option;
        }
    }
    
    function updateChoice(){
        
        var update_choice = document.getElementById("update_choice");
        
        var option = document.createElement("Option");
        option.value = "Add";
        option.text = "Add";
        update_choice.options[0] = option;
    }
</script>