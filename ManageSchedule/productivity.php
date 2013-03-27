<?php
session_start();
include_once'../HelperFiles/config.php';
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

            <div id="top_image"><img src="/Images/temp_top_logo.png" align="center">
            </div>

            <ul class="subway_tabs">
                <li><a href="/MainMenu/index.php">Welcome:</a></li>
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
                    <form  action="productivity.php" method="POST">
                        <input type="submit" value="Enter Productivity" class="subway_buttons"/>
                    </form>
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
                            Productivity:    
                        </div>

                        <div id="past_product_title"/>
                            Past Productivity Numbers:
                        </div>
                    </div>

                    <div id="product_info">
                    
                        <div id="product_list">
                            <form action="" method ="POST">
                                Wednesday:  <input type="text" id="monday_product" value="" class="product_field"/></br>
                                Thursday:   <input type ="text" id="tuesday_product" value="" class="product_field"/></br>
                                Friday:     <input type="text" id="wednesday_product" value="" class="product_field"/></br>
                                Saturday:   <input type="text" id="thursday_product" value="" class="product_field"/></br>
                                Sunday:     <input type="text" id="friday_product" value="" class="product_field"/></br>
                                Monday:     <input type="text" id="saturday_product" value="" class="product_field"/></br>
                                Tuesday:    <input type="text" id="sunday_product" value="" class="product_field"/></br>

                                </br>

                                <input type="hidden" id="productivity" name="productivity" value=""/>
                                <input type="hidden" id="generate" name="generate" value=""/>
                                <input type="hidden" id="edit" name="edit" value=""/>
                                <input type="submit" value="Enter Productivity"/>
                            </form>
                        </div>
                    </div>
                    <div id="past_product_list">
                        
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
                        <br/>
                        <br/>
                        <td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td><td>Sunday</td><td>Monday</td><td>Tuesday</td>
                        <input type="text" name="wednesday_prod" id="wednesday_prod" class="product_field">
                        <input type="text" name="thursday_prod" id="thursday_prod" class="product_field">
                        <input type="text" name="friday_prod" id="friday_prod" class="product_field">
                        <input type="text" name="saturday_prod" id="saturday_prod" class="product_field">
                        <input type="text" name="sunday_prod" id="sunday_prod" class="product_field">
                        <input type="text" name="monday_prod" id="monday_prod" class="product_field">
                        <input type="text" name="tuesday_prod" id="tuesday_prod" class="product_field">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
