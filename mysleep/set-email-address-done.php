<!DOCTYPE html>
 <?php  
    
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
if ($userId == "") {
	header("Location: login.php");
	exit;
}
$emailAddress = $_POST['emailAddress'];
?>

<html>

<body>

<?php
include 'connectdb.php';
if ($emailAddress == "") {
    mysql_query("UPDATE user_table SET emailAddress=NULL WHERE userId='$userId'");
}
else {
    mysql_query("UPDATE user_table SET emailAddress='$emailAddress' WHERE userId='$userId'");
}
mysql_close($con);
?> 

<script>
    history.go(-1); 
</script>

</body>
</html> 
