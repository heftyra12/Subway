<?php
if(isset($_SESSION['first_name']))
    unset($_SESSION['first_name']);
if(isset($_SESSION['last_name']))
    unset($_SESSION['last_name']);
if(isset($_SESSION['email']))
    unset($_SESSION['email']);
if(isset($_SESSION['emp_type']))
    unset($_SESSION['emp_type']);
if(isset($_SESSION['emp_minor']))
    unset($_SESSION['emp_minor']);
?>
