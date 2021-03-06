<!DOCTYPE html>
<?php
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if ($userType == "teacher"){
   $classId = $_SESSION['classId'];
}
$showToClass = 1;
$showToClass = $_GET['showToClass'];

$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
?>

<html style="background-image: url('assets/img/bkg-lg.jpg');">
    <head>
        <?php include 'partials/header.php' ?>
        <?php include 'partials/scripts.php' ?>
        <title>MySleep // Review: What is sleep?</title>
        <link rel="stylesheet" type="text/css" href="jqcloud.css" />
        <script type="text/javascript" src="jqcloud.js"></script>
        <script type="text/javascript">
        /*!
       * Create an array of word objects, each representing a word in the cloud
       */

          $(function() {
            // When DOM is ready, select the container element and call the jQCloud method, passing the array of words as the first argument.
            $("#wordCloud").jQCloud([],{
              width: 600,
              height: 400
            });
          });
        </script>
	<style>

	 table{
	     font-size:x-large;
	 }
	</style>
    </head>

    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php
                  require_once('partials/nav-links.php');
                  navigationLinkReview($config,$userType);
                   ?>
                   <?php
                   $tableBorder = 'borderless';
                      if($showToClass == "0" && $userType == 'teacher' && $config && $config['gradable']){
                     $tableBorder = '';
                     ?>
                   <form action="what-is-sleep-review-done" method="post">
                   <?php } ?>
                   <div class="row">
                     <div class="col-xs-10 col-md-10">
                       <div id="wordCloud" style="width: 100% ; height: 400px;"></div>
              				<table id="what-sleep-table"  class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10 table <?php echo $tableBorder; ?>">
              				    <thead>
                    					<tr>
                    					    <?php if($showToClass == "1"){ ?>
                    						        <th>What is Sleep?</th>
                                        <th><i class="fa fa-thumbs-up" style="font-size:48px;color:#fc6e63;"></i></th>
                    					    <?php }else{ ?>
                    						        <th>Name</th><th>What is Sleep?</th>
                    					    <?php
                                        if ($config && $config['gradable']) {
                                          echo '<th data-field="score">Score</th>
                                          <th data-field="comment">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Comment &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</th>';
                                        }
                                    } ?>
                    					</tr>
              				    </thead>
                          <tbody>
                              <?php if($showToClass == "0"){
                                include 'connectdb.php';
                                require_once 'utilities.php';
                                if(($userType == 'teacher') || ($userType == 'parent')) {
                                    if($userType == 'teacher') {
                                        $classId = $_SESSION['classId'];
                                        if ($config) {
                                          $result = mysql_query("SELECT * FROM fourthGradeLessonOneWhatSleep WHERE classId='$classId' and submit='1'");

                                        } else {
                                            $resultLink = getUserIdsInClass($classId);
                                            $students = join("','",$resultLink);
                                            $result = mysql_query("SELECT * FROM fourthGradeLessonOneWhatSleep WHERE userId IN ('$students') AND submit IS NOT NULL");
                                        }
                                    } else {
                                        $resultLink = getLinkedUserIds($userId);
                                        $students = join("','",$resultLink);
                                        $result = mysql_query("SELECT * FROM fourthGradeLessonOneWhatSleep WHERE userId IN ('$students') AND submit IS NOT NULL");
                                    }
                                    while($row = mysql_fetch_array($result)){
                                        $records = $records.','.$row['resultRow'];
                                        echo "<tr>";
                                        if ($config) {
                                            $name = getGroupUserNames($row['contributors']);
                                        } else {
                                            list($firstname, $lastname) = getUserFirstLastNames($row['userId']);
                                            $name = $firstname.' '.$lastname;
                                        }
                                        echo "<td>".$name."</td>";
                                        echo "<td>".$row['response']."</td>";
                                        if ($userType == 'teacher' && $config && $config['gradable']) {
                                          echo '<td><textarea class="form-control input-md" name="score[]" value="'.$row['userId'].'" rows="1">'.$row['score'].'</textarea></td>';
                                          echo '<td><textarea class="form-control input-md" name="comment[]" value="'.$row['userId'].'" rows="3">'.$row['comment'].'</textarea></td>';
                                        }
                                        echo "</tr>";
                                    }
                              }
                              mysql_close($con);
                            } ?>


                  				    </tbody>
                  				</table>
                        </div>
                      </div>
                      <?php if($showToClass == "0" && $userType == 'teacher' && $config && $config['gradable']){?>
                          <input type="text" name="records" value="<?php echo $records; ?>" style="display: none">
                          <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                          <div class="col-sm-offset-1 col-sm-10 col-md-offset-4 col-md-5">
                              <button class="btn btn-gradbg btn-roundThin btn-large btn-block" type="submit" name="save">Save</button>
                          </div>
                        </form>
                      <?php } ?>
		           </div>
	         </div>
	     </div>
	     <?php include 'partials/footer.php' ?>
      	<script>
      	 var prerow, schoolrow, adultrow;
      	 var showToClass = <?php echo $showToClass; ?>;
         if (showToClass) {
           setInterval(function(){
        	     $.ajax({
        		 type: "post",
        		 url: "what-is-sleep-process",
        		 dataType: 'json',
        	 success: function (response) {
             // var wordCounts = Object.create(null);;
              var wordArray = [];
        	 // console.log(response.row);
        	     $("#what-sleep-table tbody").empty();
        		     for (var i = 0; i < response.idList.length; i++) {
                   wordArray = wordArray.concat(getFrequency2(response.whatSleepAnswer[i]))
                   var color;
                   if (i%2==0) {
                     color = 'bubble-bg';
                   } else {
                     color = 'bubble-bb';
                   }
        			     prerow = "<tr><td><div class='speech-bubble "+color+"'><div class='bubbletext'>" + response.whatSleepAnswer[i] + "</div></div></td><td style='font-weight: bold;vertical-align: middle !important;'>" + response.agreeCount[i] + "</td><tr>";
        			     $("#what-sleep-table tbody").append(prerow);
        		     }
                  $('#wordCloud').jQCloud('update', wordArray);
        		   }

        	     });
        	 }, 2000);
         }
         function getFrequency2(string) {
           var cleanString = (string.replace(/[\.,-\/#!$%\^&\*;:{}=\-_`~()]/g,"")).toLowerCase(),
               words = cleanString.split(' '),
               frequencies = {},
               word, frequency, i;

           for( i=0; i<words.length; i++ ) {
             word = words[i];
             frequencies[word] = frequencies[word] || 0;
             frequencies[word]++;
           }

           // words = Object.keys( frequencies );
           var wordArray = [];
           var exArray = ['i','you','we','are','is','the','of','for','a','an','with'];
           for (var w in frequencies) {
             if (exArray.includes(w)) {
               continue;
             }
             wordArray.push({text:w, weight: frequencies[w]});
           }
           return wordArray;
           // return words.sort(function (a,b) { return frequencies[b] -frequencies[a];}).slice(0,cutOff).toString();
         }
      	</script>
    </body>
</html>
