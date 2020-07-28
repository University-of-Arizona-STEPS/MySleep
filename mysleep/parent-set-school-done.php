<?php   
   
session_start();
require_once('utilities.php');
$userId= $_SESSION['userId'];
if($userId==""){
    header("Location: login");
    exit;
}

include 'connectdb.php';
$result = mysql_query("SELECT schoolId FROM user_table Where userId = '$userId'");
$row = mysql_fetch_array($result);
//echo $row['schoolId'];
if(!empty($row['schoolId'])){
    $arrSettedSchoolId = explode("," , $row['schoolId']);
    array_push($arrSettedSchoolId, $_POST['schoolId']);
}else{
    $arrSettedSchoolId = [];
    array_push($arrSettedSchoolId, $_POST['schoolId']);
}
$strSettedSchoolId = implode(",",$arrSettedSchoolId);
mysql_query("UPDATE user_table SET schoolId = '$strSettedSchoolId' WHERE userId = $userId");
exit;
?>
