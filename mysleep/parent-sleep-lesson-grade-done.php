<!DOCTYPE html>
<?php   
   
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login.php");
    exit;
}
if($userType!="parent"){
    header("Location: login.php");
    exit;
}


if(isset($_POST['grade'])){
    if($_POST['grade']!= "null"){
	$_SESSION['parentLessonGrade'] = $_POST['grade'];
    header("Location: parent-sleep-lesson");
    exit;
    }else{
	header("Location: parent-sleep-lesson-grade");
	exit;
    }
}else{    
    header("Location: parent-sleep-lesson-grade?grade=null");
    exit;
}

?>
