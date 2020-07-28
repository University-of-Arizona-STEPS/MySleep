<!DOCTYPE html>
<?php  
   
require_once('utilities.php');     
session_start();
$userId = $_SESSION['userId'];
if ($userId == ""){
	header("Location: login");
	exit;
}
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];
?>

<html>
<head>
	<script type="text/javascript">
	 window.onload = function () {
	     window.history.go(-1);
	 }
	</script>
    </head>
<body>

<?php
   include 'connectdb.php';
   $linkUserId = $_POST['linkUserId'];
$result = mysql_query("SELECT FROM class_table WHERE userId='$linkUserId' AND classId='$classId'");
if(mysql_num_rows($result) == 0){
    $result = mysql_query("INSERT INTO class_table (userId, classId) VALUES ('$linkUserId','$classId')");
    if (!$status) {
	error_exit( mysql_error());
    }
}
mysql_close($con);
exit;
?> 


</body>
</html> 
