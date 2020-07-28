<?php
   

  require_once('utilities.php');
  session_start();
  $userId= $_SESSION['userId'];
  #checkauth();

  $response=  mysql_escape_string($_POST["response"]);

  include 'connectdb.php';
  
  $q = mysql_query("INSERT INTO bodyChanger(userId, endocrine) VALUES ('$userId', '$response')");

  if (!$q) {
    $message = 'Could not enter answers to the database: ' . mysql_error();
    $data['success'] = false;
    $data['errors']  = $message;
  }
  else {
    // show a message of success and provide a true success variable
    $data['success'] = true;
    $data['message'] = 'Activity successfully submitted!';
  }

  mysql_close($con);

  // return all our data to an AJAX call
  echo json_encode($data);
?>
