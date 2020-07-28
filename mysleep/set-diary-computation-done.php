<!DOCTYPE html>
<?php
   

require_once('utilities.php');
checkauth();
$userId= $_SESSION['userId'];
$schoolId = $_SESSION['schoolId'];
$classId = $_SESSION['classId'];


    if($_POST['diary-computation-checkbox'] == 'on'){
	$status = 1;
    }else{
	$status = 0;
    }
include 'connectdb.php';
mysql_query("UPDATE class_info_table SET diaryComputation='$status' WHERE classId='$classId'");
mysql_close($con);

exit;
?>
