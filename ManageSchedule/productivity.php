<?php
session_start();
include_once'../HelperFiles/config.php';
include_once'../../Subway/HelperFiles/unsetEmpFields.php';

if (isset($_SESSION['no_product']))
    unset($_SESSION['no_product']);

//for 1 to 7 (days) 
//$avail_arry=array();
//$avail_qry = mysqli_query($db_connect,"select employee_id, start, end from subway.availability where day=1 order by start asc");
//while($res = mysql_fetch_array($avail_qry)) {
//    $dataArray[$res['id']] = $res['employee_id'];
//    echo($res['id']);
//    $dataArray[$res['start']] = $res['start'];
//    $dataArray[$res['end']] = $res['end'];
//}
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

            <div id="tab_bar"></div>
            
            <div id="small_body">

                <div id="small_left">
                    <br/>
                    <br/>
                    <div id="small_left_buttons">
                        <form action="index.php" method="POST">
                            <input type="submit" value="Generate Schedule" class="subway_buttons"/>
                        </form>
                        <br/>
                        <form action="edit.php" method="POST">
                            <input type="submit" value="Edit Schedule" class="subway_buttons"/>
                        </form>
                    </div>
                </div>

                <div id="small_right">
                    <div id="prod_table">
                    <form>
                        <table style="text-align:right">
                            <tr><th id="table_title" colspan="8">Enter Productivity:</th></tr>
                            <tr><td class="product_label">Wednesday</td><td class="product_label">Thursday</td>
                                <td class="product_label">Friday</td><td class="product_label">Saturday</td>
                                <td class="product_label">Sunday</td><td class="product_label">Monday</td>
                                <td class="product_label">Tuesday</td>
                            </tr>
                            <tr><td><input type ="text" name="wed_prod" id="wed_prod" class="product_field"></td>
                                <td><input type="text" name="thur_prod" id="thur_prod" class="product_field"></td>
                                <td><input type="text" name="fri_prod" id="fri_prod" class="product_field"></td>
                                <td><input type="text" name="sat_prod" id="sat_prod" class="product_field"></td>
                                <td><input type="text" name="sun_prod" id="sun_prod" class="product_field"></td>
                                <td><input type="text" name="mon_prod" id="mon_prod" class="product_field"></td>
                                <td><input type="text" name="tues_prod" id="tues_prod" class ="product_field"></td>
                            </tr>


                            <input type="hidden" id="productivity" name="productivity" value=""/>
                            <input type="hidden" id="generate" name="generate" value=""/>
                            <input type="hidden" id="edit" name="edit" value=""/>
                            <tr><th colspan="8"><input type="submit" value="Enter Productivity"/></th></tr>
                        </table>  
                    </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
