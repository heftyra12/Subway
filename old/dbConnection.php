<?php

   

$server = 'localhost';
$user = 'root@localhost';
$pass = '';
$dbname = 'subway';

$con = mysql_connect($server, $user, $pass) or die("Can't connect");
mysql_select_db($dbname);
    
?>
