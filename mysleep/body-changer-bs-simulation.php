<!DOCTYPE html>
<?php
session_start();
require_once('utilities.php');
$userId= $_SESSION['userId'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$userType = $_SESSION['userType'];
if($userId==""){
    header("Location: login");
    exit;
}
if(empty($_SESSION['clickTimesBS'])){
    $_SESSION['clickTimesBS']=1;
}else{
    $_SESSION['clickTimesBS']+=1;
}
$buttonName = "Next";
$link = "body-changer-bs-simulation-input";
$hours = "";
if (isset($_POST["formSubmit"])) {
    $hours=$_POST["sleephours"];
    if (!empty($hours)) {
	switch ($hours) {
	    case "A":
	        array_push($_SESSION['hoursBS'], 10);
		array_push($_SESSION['timeBS'], 84);
		array_push($_SESSION['radioBS'], 'A');
		$imgSrc = "images/body-changer/bs910.jpg";
		break;
	    case "B":
	        array_push($_SESSION['hoursBS'], 9);
		array_push($_SESSION['timeBS'], 84);
		array_push($_SESSION['radioBS'], 'B');
		$imgSrc = "images/body-changer/bs910.jpg";
		break;
	    case "C":
		array_push($_SESSION['hoursBS'], 8);
		array_push($_SESSION['timeBS'], 87);
		array_push($_SESSION['radioBS'], 'C');
		$imgSrc = "images/body-changer/bs8.jpg";
		break;
	    case "D":
	 	array_push($_SESSION['hoursBS'], 7);
		array_push($_SESSION['timeBS'], 90);
		array_push($_SESSION['radioBS'], 'D');
		$imgSrc = "images/body-changer/bs67.jpg";
		break;
	    case "E":
		array_push($_SESSION['hoursBS'], 6);
		array_push($_SESSION['timeBS'], 90);
		array_push($_SESSION['radioBS'], 'E');
		$imgSrc = "images/body-changer/bs67.jpg";
		break;
	    case "F":
		array_push($_SESSION['hoursBS'], 5);
		array_push($_SESSION['timeBS'], 95);
		array_push($_SESSION['radioBS'], 'F');
		$imgSrc = "images/body-changer/bs5.jpg";
		break;
	    case "G":
		array_push($_SESSION['hoursBS'], 4);
		array_push($_SESSION['timeBS'], 98);
		array_push($_SESSION['radioBS'], 'G');
		$imgSrc = "images/body-changer/bs4.jpg";
		break;
	    default: echo "Please submit the form.";
		$_SESSION['clickTimesBS']-=1;
	}
   if($_SESSION['clickTimesBS']>2 && $_SESSION['clickTimesBS']<7){
								 $_SESSION['bsSim'] = 1;
	    $question = "Question";
	    $displayQuestion = true;
	}else{
	    $question = "Non-Question";
	    $displayQuestion = false;
	}
    }
}
//debugToConsole('hours', $_SESSION['hoursHB']);

if($_SESSION['clickTimesBS'] == 7){
    $_SESSION['clickTimesBS']=1;
    $show = true;
    $buttonName = "Next";
    $link = "body-changer-simulation-selection";
}
//set question two flag
$displayQuestionTwo = true;
if(isset($_SESSION['bsAnswer'])){
    if($_SESSION['bsAnswer'] == 'correct'){
	$displayQuestionTwo = false;
    }else{
	$displayQuestionTwo = true;
    }
   }
//debugToConsole('answer', $_SESSION['hbAnswer']);
include 'connectdb.php';
$result =mysql_query("SELECT endocrine FROM bodyChanger where userId='$userId' AND endocrine!='null' Order by recordId DESC LIMIT 1");
$row = mysql_fetch_array($result);
$response = $row['endocrine'];
mysql_close($con);
?>
<html>
    <head>
        <?php include 'partials/header.php'?>
	<title>Simulation</title>
	<style>
	 #chart-scatter{
	     width: 100%;
	     min-height: 500px;
	 }
	 #id_whiteBoard{
	 cursor: pointer;
	 /*background: url("images/body-changer/bs_background.png");*/
	   /*  background-size: 100% 100%;*/
	 }
	 .select {
	     width: 28px;
	     height: 28px;
	     position: relative;
	     background: #fcfff4;
	     background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	     background: linear-gradient(to bottom, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
	 }
	 .select label {
	     width: 20px;
	     height: 20px;
	     cursor: pointer;
	     position: absolute;
	     left: 4px;
	     top: 4px;
	     background: -webkit-linear-gradient(top, #FFFFFF 0%, #FFFFFF 100%);
	     background: linear-gradient(to bottom, #FFFFFF 0%, #FFFFFF 100%);
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px rgba(0, 0, 0, 0.5), 0px 1px 0px white;
	 }
	 .select label:after {
	     content: '';
	     width: 16px;
	     height: 16px;
	     position: absolute;
	     top: 2px;
	     left: 2px;
	     background: #6495ED;
	     background: -webkit-linear-gradient(top, #6495ED 0%, #6495ED 100%);
	     background: linear-gradient(to bottom, #6495ED 0%, #6495ED 100%);
	     opacity: 0;
	     border-radius: 50px;
	     box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0, 0, 0, 0.5);
	 }
	 .select label:hover::after {
	     opacity: 0.3;
	 }
	 .select input[type=radio] {
	     visibility: hidden;
	 }
	 .select input[type=radio]:checked + label:after {
	     opacity: 1;
	 }


	</style>
  <?php include 'partials/scripts.php' ?>
    </head>
    <body>
	<!-- <div class="col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6" style="padding-top: 2em">
	    <h1 id="question"><center><?php echo $question ?></center></h1>
	     </div> -->
	<div id="animation" style="margin-top: 15em">
	    <h3 class="text-center" class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">Estimate the number of insulin and glucose molecules, then hit the space bar to continue.</h3>
	    <img src=<?php echo $imgSrc ?> alt="Animation" class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4">
	</div>
	<form id="answer" style="display: none">
	    <div class="row" style="padding-top: 2em;" >
		<?php if($displayQuestion){ ?>
		    <div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
			<h1 class="text-center" style="font-family:Comic Sans MS; color:red;font-size:200%;"><strong>Draw a conclusion from your data points</strong></h1>
		    </div>
		    <div >
			<div id="chart-scatter" class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8" style="display:none"></div>
		    </div>
		    <div id="container1" class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
			<div>
			    <div class="row">
				<h3>Summarize the relationship between sleep and the endocrine system shown in the graph by selecting the word that completes the sentence below the graph.</h3>
			    </div>
			    <div class="row">
				<canvas id="id_whiteBoard" name="whiteBoard" style="border:1px solid #d3d3d3;"></canvas>
			    </div>
			    <!--<div class="row">
				<button type="button" class="btn btn-danger btn-sm" onclick="redraw();">Clear</button>
			    </div>-->
			</div>
			<?php if($displayQuestionTwo){ ?>
			    <div>
				<div class="row">
				    <h3>When nightly sleep decreased, then the blood glucose:</h3>
				</div>
				<table>
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_increase" data-toggle="modal" data-target="#correct"/><label for="id_increase"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 30px">Increased</span>
					</td>
				    </tr>
				    <tr style="height: 1em">
				    </tr>
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_decrease" onclick="showModal()"/><label for="id_decrease"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 30px">Decreased</span>
					</td>
				    </tr>
				    <tr  style="height: 1em">
				    </tr>
				    <tr>
					<td>
					    <section title="Select"><div class="select"><input type="radio" value="" name="answer" id="id_noChange" onclick="showModal()"/><label for="id_noChange"></label></div></section>
					</td>
					<td>
					    <span style="font-size: 30px">Did no Change</span>
					</td>
				    </tr>
				</table>
			    </div>
			<?php } ?>
		    </div>
		<?php }else{ ?>
		    <div class="col-md-offset-2 col-md-offset-8 col-sm-offset-2 col-sm-8">
			<h1 class="text-center" style="font-family:Comic Sans MS; color:red;font-size:200%;"><strong>Can you draw a conclusion from your data points? Click next obtain more data.</strong></h1>
		    </div>
		    <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
			<div id="chart-scatter"></div>
		    </div>
		    <?php if($show){ ?>
			<div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
			    <!-- <h4 style="margin-top: 1em">Answer the questions following the complete graph in your lab notebook: <a href="https://www.google.com/docs" target="_blank">Google Docs</a>
				<ol>
				    <li>Normal blood glucose levels are between 72 and 108.  What is the minimum hours of sleep that would help keep glucose levels in the middle of the range? </li>
				</ol>
			    </h4> -->
			    <h4>Implications of the research:  People who don’t sleep enough tend to eat more snacks for energy. How does this affect health over time?</h4>
			    <textarea class="form-control" rows="5" name="response" id="id_response"><?php echo $response ?></textarea>
			    <p><b>Implications are the “take away” statements that help others</b> understand what the research results mean to them.</p>
			</div>
		    <?php } ?>
		<?php } ?>
	    </div>
	    <?php if(!$displayQuestion || !$displayQuestionTwo){ ?>
	    <div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2" style="margin-top: 2em">
		<?php if($_SESSION['clickTimesBS'] == 7){ ?>
		    <?php if($userType == 'student'){ ?>
			<button type="button" class="btn btn-default btn-lg" id="id_submit">Submit</button>
		    <?php }else{ ?>
			<button type="button" class="btn btn-default btn-lg" onClick="location.href='body-changer-simulation-selection'">Done</button>
		    <?php } ?>
		<?php }else{ ?>
		    <a type="submit" href=<?php echo $link ?> class="btn btn-info btn-lg" role="button"><?php echo $buttonName ?></a>
		<?php } ?>
		</div>
	    <?php } ?>
	</form>
	<div id="final-result"  style="display: none">
	    <div  class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
		<div id="chart-scatter-final"></div>
	    </div>
      <div  class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
        <?php include 'add-group-member-button.php' ?>
      </div>
      <div  class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
		    <h4>Implications of the research:  People who don’t sleep enough tend to eat more snacks for energy. How does this affect health over time?</h4>
	    </div>
	    <div class="col-md-offset-2 col-md-8 col-sm-offset-2 col-sm-8">
		<!--	<h4 style="margin-top: 1em">Answer the questions following the complete graph in your lab notebook: <a href="https://www.google.com/docs" target="_blank">Google Docs</a>
		<ol>
		    <li>Normal blood glucose levels are between 72 and 108.  What is the minimum hours of sleep that would help keep glucose levels in the middle of the range? </li>
		</ol>
			    </h4>-->

		<textarea class="form-control" rows="5" name="response" id="id_response"><?php echo $response ?></textarea>
		<p><b>Implications are the “take away” statements that help others</b> understand what the research results mean to them.</p>
	    </div>
	    <div>
		<div class="col-md-offset-5 col-md-2 col-sm-offset-5 col-sm-2" style="margin-top: 2em">
		    <?php if($userType == 'student'){ ?>
			<button type="button" class="btn btn-default btn-lg" id="id_submit">Submit</button>
		    <?php }else{ ?>
			<button type="button" class="btn btn-default btn-lg" onClick="location.href='body-changer-simulation-selection'">Done</button>
		    <?php } ?>
		    <!-- <a type="submit" href="body-changer-simulation-selection"  class="btn btn-info btn-lg" role="button">Next</a>-->
		</div>
	    </div>
	</div>
	<!-- Model -->
	<div id="correct" class="modal fade"  role="dialog" data-modal-index="1" data-backdrop="static" data-keyboard="false" aria-labelledby="correct">
	    <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-body">
			<h4>Great choice, insufficient sleep increases the glucose in your blood. Do the results match your hypothesis which was: If nightly sleep decreases, then blood glucose will <span id="hypothesis" style="color: red"></span>.</h4>
			<div class="dropdown">
			    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown">Please Select One
				<span class="caret"></span></button>
			    <ul class="dropdown-menu">
				<li><a href="#" onclick="showResult()" data-dismiss="modal">Yes</a></li>
				<li><a href="#" onclick="showResult()" data-dismiss="modal">No</a></li>
			    </ul>
			</div>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="wrong" role="dialog" data-modal-index="1" data-backdrop="static" data-keyboard="false" aria-labelledby="wrong">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			<h4>Not the best choice</h4>
			<h4>Look at the pattern of dots on the graph and click “No” to try drawing the line again. If you would like to input more values for hours of sleep click “Yes”.</h4>
		    </div>
		    <div class="modal-footer">
			<!--<button data-toggle="modal" data-target="#choice" type="button" class="btn btn-default" data-dismiss="modal">Ok</button>-->
			<button onclick="location.href = 'body-changer-bs-simulation-input?answer=wrong'" type="button" class="btn btn-default" data-dismiss="modal">Yes</button>
			<button onclick="redraw();" type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    </div>
		</div>
	    </div>
	</div>
	<div class="modal fade" id="wrong-2" role="dialog" data-modal-index="1" data-backdrop="static" data-keyboard="false" aria-labelledby="wrong-2">
	    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-body">
			<h4>Not the best choice. Please input more values.</h4>
		    </div>
		    <div class="modal-footer">
			<button onclick="location.href = 'body-changer-bs-simulation-input?answer=wrong'" type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
		    </div>
		</div>
	    </div>
	</div>
    </body>

    <script type="text/javascript">
     var hours = <?php echo json_encode($_SESSION['hoursBS']); ?>;
     var time = <?php echo json_encode($_SESSION['timeBS']); ?>;
     var canvas;
     var modalFlag = false;
     var active = false;
     //console.log(hours);
     //console.log(time);
     $(document).keypress(function(e) {
	 if(e.which == 32 && !active) {
	     replace();
	     e.preventDefault();
	 }
     });

     function replace(){
	 if(!$('#answer').is(':visible')){
	     if($('#animation').is(':visible')){

		 $('#animation').hide();
		 google.charts.load('current', {'packages':['corechart']});
		 google.charts.setOnLoadCallback(drawChart);
		 $('#answer').show();
		 canvas = document.getElementById('id_whiteBoard');
		 if (canvas !== null){
		     canvas.style.width ='700px'; //style size is the CSS size
		     canvas.style.height='500px';
		     //then set the internal size to match
		     canvas.width  = canvas.offsetWidth; //need to set canvas size
		     canvas.height = canvas.offsetHeight;
     }
     active = true;
	     }
	 }

     }

     //setTimeout(replace, 5000);

     function showModal(){
	 if(modalFlag){
	     $('#wrong-2').modal();
	 }else{
	     $('#wrong').modal();
	     modalFlag = true;
	 }
     }

     function showResult(){
	 $('#answer').hide();
	 google.charts.load('current', {'packages':['corechart']});
	 google.charts.setOnLoadCallback(drawFinalChart);
	 $('#final-result').show();
     }

     function drawFinalChart(){
	 var data = new google.visualization.DataTable();
	 data.addColumn('number', 'Blood Glucose');
	 data.addColumn('number', 'Average Sleeping Hours for Last Week');


	 data.addRows([
	     [10, 84],
	     [9, 84],
	     [8, 87],
	     [7, 90],
	     [6, 90],
	     [5, 95],
	     [4, 98]
	 ]);


         var options = {
             title: 'Blood Clucose Data',
             vAxis: {title: 'Blood Glucose (mg/dl)',
		     ticks: [75, 80, 85, 90, 95, 100]
	     },
             hAxis: {title: 'Average Sleeping Hours for Last Week (hrs)',
		     ticks: [4, 5, 6, 7, 8, 9, 10]
	     },
             legend: 'none',
	     height: 500
         };

         var chart = new google.visualization.ScatterChart(document.getElementById('chart-scatter-final'));
         chart.draw(data, options);
     }

     function drawChart() {
         var data = new google.visualization.DataTable();
	 data.addColumn('number', 'Blood Glucose');
	 data.addColumn('number', 'Average Sleeping Hours for Last Week');

	 for(var i = 0; i < hours.length; i++){
	     data.addRow([hours[i], time[i]]);
         }

         var options = {
             title: 'Blood Glucose Data',
             vAxis: {title: 'Blood Glucose (mg/dl)',
		     ticks: [75, 80, 85, 90, 95, 100]
	     },
             hAxis: {title: 'Average Sleeping Hours for Last Week (hrs)',
		     ticks: [4, 5, 6, 7, 8, 9, 10]
	     },
             legend: 'none',
			 width: 700,
	     height: 500
         };

         var chart = new google.visualization.ScatterChart(document.getElementById('chart-scatter'));
         google.visualization.events.addListener(chart, 'ready', function () {
			  if(canvas != null){
			canvas.style.backgroundImage = 'url(' + chart.getImageURI() + ')';
			  }
			});
		 chart.draw(data, options);
     }


     // painting for question 3
     canvas = document.getElementById('id_whiteBoard');
     if (canvas !== null){
	 canvas.style.width ='100%'; //style size is the CSS size
	 canvas.style.height='300px';
	 //then set the internal size to match
	 canvas.width  = canvas.offsetWidth; //need to set canvas size
	 canvas.height = canvas.offsetHeight;
	 var ctx = canvas.getContext('2d');
	 click = false;


	 /*$(window).mousedown(function(){
	     click = true;
	 });

	 $(window).mouseup(function(){
	     click = false;
	 });

	 $('canvas').mousedown(function(e){
	     draw(e.pageX, e.pageY);
	 });

	 $('canvas').mouseup(function(e){
	     draw(e.pageX, e.pageY);
	 });

	 $('canvas').mousemove(function(e){
	     if(click === true){
		 draw(e.pageX, e.pageY);
	     }
	 });*/
     }

     function draw(xPos, yPos){
	 ctx.beginPath();
	 ctx.fillStyle = '#000000';
	 ctx.arc(xPos - $('canvas').offset().left, yPos - $('canvas').offset().top, 4, 0, 2 * Math.PI);
	 ctx.fill();
	 ctx.closePath();
     }

     function redraw(){
	 ctx.clearRect(0, 0, canvas.width, canvas.height);
     }

     $(function() {
	 var h = localStorage.getItem('bsH');
	 $("#hypothesis").text(h);
     });

     //submit function
     $('#id_submit').click(function() {
var result = confirm('Want to submit?');
if(!result){
	return false;
}
	 var formData = {
	     'response': $('#id_response').val()
	 };

	 $.ajax({
	     type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
	     url         : 'body-changer-bs-simulation-done', // the url where we want to POST
	     data        : formData, // our data object
	     dataType    : 'json', // what type of data do we expect back from the server
	     encode      : true
	 })
	  .success(function(data) {
	      if (!data.success) {
		  alert(data.errors);
	      }
	      else {
		  alert(data.message);
		  location.href = 'body-changer-simulation-selection';
	      }
	  });
     });
    </script>
</html>
