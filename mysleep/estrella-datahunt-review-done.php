<!DOCTYPE html>
<?php
  
require_once('utilities.php');
session_start();

$workId = $_POST['workId'];
$score = $_POST['score'];
$comment = $_POST['comment'];

include 'connectdb.php';

$status = mysql_query("UPDATE fourthGradeLessonTwoEstrellaActogram SET score='$score', comment='$comment' WHERE recordRow='$workId'");
if (!$status) {
    $message = 'Could not enter answers to the database: ' . mysql_error();
    error_exit($message);
}

mysql_close($con);
