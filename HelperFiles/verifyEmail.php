<?php

session_start();

$employees_to_be_emailed = $_POST['email_employees'];

$to = "halversotm30@uww.edu";
$subject = "Mysterious Eamil From The Internet";
$text = "WOW";
$headers = "From: webmaster@example.com";

if(mail($to,$subject,$text,$headers) == true)
        echo "worked";
else
    echo "guess not";

?>
