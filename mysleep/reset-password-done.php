<!DOCTYPE html>
<?php
   
require_once('utilities.php');     
session_start();
$userId= $_SESSION['userId'];
$targetUserId = $_POST["targetUserId"];
if ($userId == "") {
    header("Location: login.php");
    exit;
}
?>


<html>
    <head>
	<?php include 'partials/header.php' ?>
        <title>MySleep //Reset Password</title>
    </head>
    <body>
<?php
// Check if everything is filled
if (empty($targetUserId)) {
    echo "<div class='row_settings'>";
    echo   "Everything has to be filled in the page.</br></br>";
    echo   "<input class='submit_all' type='submit' onclick='history.go(-1); return false;' value='Return' /> ";
    echo "</div>";
    exit;
}

// check whether userid exists
include 'connectdb.php';
$result = mysql_query("SELECT * FROM user_table WHERE userId='$targetUserId'");
$rowCount = mysql_num_rows($result);
if ($rowCount == 0) {
    echo "<div class='row_settings'>";
    echo   "Invalid user ID.</br></br>";
    echo   "<input class='submit_all' type='submit' onclick='history.go(-1); return false;' value='Return' /> ";
    echo "</div>";
    mysql_close($con);
    exit;
}

// Update database with new password
$newPassword = "zfactor";
$encrypted = SHA1($newPassword);
$status = mysql_query("UPDATE user_table SET password='$encrypted' WHERE userId='$targetUserId'"); 
if (!$status) {
    error_exit('Could not update new password to database: ' . mysql_error());
}
else {
    //echo "<div class='row_settings'>";
   // echo   "New password: " . $newPassword . "<br><br>";
   // echo   "<input class='submit_all' type='submit' onclick='history.go(-1); return false;' value='Return' /> ";
   // echo "</div>";
}
mysql_close($con);
?>

<script>
    history.go(-2); 
</script>

</body>

</html> 
