<?php
session_start();
echo "Change Password";

$user = $_SESSION['user_name'];
$password= $_SESSION['password'];

?>
<script language="Javascript">

alert("Enter new password");
</script>