<?php
session_start();
include_once'../HelperFiles/config.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

if(isset($_SESSION['no_product']))
    unset($_SESSION['no_product']);

?>

<!DOCTYPE html>
<html>
    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel='stylesheet' href='/CSS/subway_css.css' type='text/css'>

        <title></title>
    </head>
    <body>

        <div id="page_top">

            <div id="top_image"><img src="/Images/temp_top_logo_3.png" align="center">
            </div>

            <ul class="subway_tabs">
                <li><a href="/MainMenu/index.php">Home:</a></li>
                <li class="current_position">Create Schedule</a></li>
                <li><a href="/ViewSchedule/index.php">View Schedule:</a></li>
                <li><a href="/ManageEmployee/index.php">Employees:</a></li>
                <li><a href="/EditRequests/index.php">Requests:</a></li>
                <li><a href="/ScheduleParameters/index.php">Business Rules:</a></li>
            </ul>     

            <div id="tab_bar">
            </div>

            <div id="product_body">

                <div id="product_left">
                    <form action="index.php" method="POST">
                        <input type="submit" value="Generate Schedule" class="subway_buttons"/>
                    </form>
                    <form action="edit.php" method="POST">
                        <input type="submit" value="Edit Schedule" class="subway_buttons"/>
                    </form>
                </div>

                <div id="product_right">

                    <div id="product_titles">

                        <div id="current_product_title">
                            Enter Productivity:    
                        </div>

                        <div id="past_product_title"/>
                            Past Productivity Numbers:
                        </div>
                    </div>

                    <div id="product_info">
                    
                        <div id="product_list">
                            <table style="text-align:right">
                                <tr><td class="product_label">Productivity</td><td class="product_label">Wednesday</td><td class="product_label">Thursday</td><td class="product_label">Friday</td><td class="product_label">Saturday</td><td class="product_label">Sunday</td><td class="product_label">Monday</td><td class="product_label">Tuesday</td></tr>
                            </table>
                            <table>
                            <form action="" method ="POST">
                            <!--6:00-10:am BLOCK-->
                            <tr><th>06:00 - 10:00:</th><th><input type="text" id="wednesday0600" value="" class="product_field" required></th>
                                <th><input type="text" id="thursday0600" value="" class="product_field" required></th>
                                <th><input type="text" id="friday0600" value="" class="product_field" required></th>
                                <th><input type="text" id="saturday0600" value="" class="product_field" required></th>
                                <th><input type="text" id="sunday0600" value="" class="product_field" required></th>
                                <th><input type="text" id="monday0600" value="" class="product_field" required></th>
                                <th><input type="text" id="tuesday0600" value="" class="product_field" required></th>
                            </tr>
                            <!--10:am BLOCK-->
                            <tr><th>10:00:</th><th><input type="text" id="wednesday1000" value="" class="product_field" required/></th>
                                <th><input type="text" id="thursday1000" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1000" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1000" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1000" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1000" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1000" value="" class="product_field" required/></th>
                            </tr>
                            <!--11:am BLOCK-->
                            <tr><th>11:00</th><th><input type="text" id="wednesday1100" value="" class="product_field" required/></th>
                                <th><input type="text" id="thursday1100" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1100" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1100" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1100" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1100" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1100" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>12:00</th><th><input type="text" id="wednesday1200" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday1200" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1200" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1200" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1200" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1200" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1200" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>1:00</th><th><input type="text" id="wednesday1300" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday1300" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1300" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1300" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1300" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1300" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1300" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>2:00</th><th><input type="text" id="wednesday1400" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday1400" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1400" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1400" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1400" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1400" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1400" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>3:00</th><th><input type="text" id="wednesday1500" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday1500" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1500" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1500" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1500" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1500" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1500" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>4:00</th><th><input type="text" id="wednesday1600" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday1600" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1600" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1600" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1600" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1600" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesay1600" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>5:00</th><th><input type="text" id="wednesday1700" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday1700" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1700" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1700" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1700" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1700" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1700" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>6:00</th><th><input type="text" id="wednesday1800" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday1800" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1800" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1800" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1800" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1800" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1800" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>7:00</th><th><input type="text" id="wednesday1900" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday1900" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday1900" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday1900" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday1900" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday1900" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday1900" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>8:00</th><th><input type="text" id="wednesday2000" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday2000" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday2000" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday2000" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday2000" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday2000" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday2000" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>9:00</th><th><input type="text" id="wednesday2100" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday2100" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday2100" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday2100" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday2100" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday2100" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday2100" value="" class="product_field" required/></th>
                            </tr>
                            <tr><th>10:00</th><th><input type="text" id="wednesday2200" value="" class="product_field" required/></th>
                            <th><input type="text" id="thursday2200" value="" class="product_field" required/></th>
                                <th><input type="text" id="friday2200" value="" class="product_field" required/></th>
                                <th><input type="text" id="saturday2200" value="" class="product_field" required/></th>
                                <th><input type="text" id="sunday2200" value="" class="product_field" required/></th>
                                <th><input type="text" id="monday2200" value="" class="product_field" required/></th>
                                <th><input type="text" id="tuesday2200" value="" class="product_field" required/></th>
                            </tr>
                            
                            <input type="hidden" id="productivity" name="productivity" value=""/>
                                <input type="hidden" id="generate" name="generate" value=""/>
                                <input type="hidden" id="edit" name="edit" value=""/>
                                <tr><th colspan="8"><input type="submit" value="Enter Productivity"/></th></tr>
                            </table>  
                            </form>
                        </div>
                        
                        <div id="past_product_list">
                        
                            <form action ="" method="POST">
                        Select Week:<select name="weeks_of_prod" id="weeks_of_prod" value="">
                         <?php
                            for ($x = 0; $x < 5; $x++) {
                                echo "<option>Week1</option>";
                                echo "<option>Week2</option>";
                                echo "<option>Week3</option>";
                                echo "<option>Week4</option>";
                                echo "<option>Week5</option>";
                            }
                        ?>
                        </select>
                        <input type="submit" value="Select Week"/>
                            </form>
                    </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</body>
</html>

