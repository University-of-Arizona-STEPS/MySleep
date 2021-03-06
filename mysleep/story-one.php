<!DOCTYPE html>
<?PHP
require_once('utilities.php');
session_start();
$userId= $_SESSION['userId'];
$userType = $_SESSION['userType'];
$lessonNum = $_GET['lesson'];
$activityNum = $_GET['activity'];
$config = getActivityConfigWithNumbers($lessonNum, $activityNum);
$query = $_SERVER['QUERY_STRING'];
unset($_SESSION['current_config']);
$_SESSION['current_config'] = $config;

$story = 1;
unset($_SESSION['current_work']);
if (!$config) {
  $result = mysql_query("SELECT happen, factor, affect FROM fifthGradeLessonOneWorksheet WHERE userId='$userId' and story='$story' ORDER BY resultRow DESC LIMIT 1;");
} else {
  $result = mysql_query("SELECT * FROM fifthGradeLessonOneWorksheet WHERE contributors LIKE '%$userId%' and story='$story' ORDER BY resultRow DESC LIMIT 1;");
}
$numRow = mysql_num_rows ($result);
$row = mysql_fetch_array($result);
$happen = $row['happen'];
$factor = $row['factor'];
$affect = $row['affect'];
if ($numRow>0) {
  $_SESSION['current_work'] = $row;
  $resultRow = $row['resultRow'];
 }else {
  $resultRow = -1;
}
?>
<html style="background-image: url('assets/img/bkg-lg.jpg');">

    <head>
        <?php require 'partials/header.php' ?>
        <title>MySleep // Story One</title>
    </head>
    <?php include 'partials/scripts.php' ?>
    <body>
        <?php require 'partials/nav.php' ?>
        <div class="wrapper">
            <div class="main main-raised">
                <div class="container">
                  <?php if ($config) {
                    require_once('partials/nav-links.php');
                    navigationLink($config,$userType,array('linkable'  => true));
                  } else {?>
                    <div class="row">
                        <div class="col-xs-offset-1 col-xs-10 col-sm-10">
                            <ol class="breadcrumb">
                                <li><a href="#" onclick="location.href='main-page'">Home</a></li>
                                <li><a href="#" onclick="location.href='sleep-lesson'">Lessons</a></li>
                                <li><a href="#" onclick="location.href='fifth-grade-lesson-menu?lesson=1'">Lesson One</a></li>
				<li><a href="#" onclick="location.href='fifth-grade-lesson-activity-menu?lesson=1&activity=2'">Activity One</a></li>
                                <li><a href="story-list">Story Menu</a></li>
                                <li class="active">Story One</li>
                            </ol>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="row">
			<div class="col-md-8 col-md-offset-2">
			    <div class="card card-nav-tabs">
				<div class="header header-success">
				    <div class="nav-tabs-navigation">
					<div class="nav-tabs-wrapper">
					    <ul class="nav nav-tabs" data-tabs="tabs">
						<li class="active">
						    <a href="#one" data-toggle="tab">
							<i class="material-icons">filter_1</i>
							Breaking news
						    </a>
						</li>
						<li>
						    <a href="#two" data-toggle="tab">
							<i class="material-icons">filter_2</i>
							Beyond headline
						    </a>
						</li>
						<li>
						    <a href="#three" data-toggle="tab">
							<i class="material-icons">filter_3</i>
							Analysis
						    </a>

						</li>
            <li>
						    <a href="#four" data-toggle="tab">
							<i class="material-icons">filter_4</i>
							Worksheets
						    </a>

						</li>
						<!--<li>
						    <a href="#four" data-toggle="tab">
							<i class="material-icons">filter_4</i>
							Four
						    </a>

						</li>-->
					    </ul>
					</div>
				    </div>
				</div>
				<div class="content">
				    <div class="tab-content">
					<div class="tab-pane active" id="one">
                                            <style>.newspaper:after {
						background: linear-gradient(-45deg, #ffffff 8px, transparent 0), linear-gradient(45deg, #ffffff 8px, transparent 0);
						background-position: left bottom;
						background-repeat: repeat-x;
						background-size: 16px 16px;
						content: " ";
						display: block;
						position: absolute;
						bottom: 0px;
						left: 0px;
						width: 100%;
						height: 16px;
					     }</style>
                                            <div class="newspaper" style="position:relative;padding:0 0 32px 0;background-image: url('assets/img/paper-bkg.png');padding:1.3em;">
						<img src="images/stories/tabletone/tab1.png" class="img-responsive" style="margin-bottom:1em;min-width:100%;">
						<h5>Massive oil tanker crashes, causes destruction</h5>
						<div style="column-count:2;margin-bottom:2em;">
						    <h6><b>March 24, 1989</b></h6>
						    <p>Just after midnight, the EXXON Valdez, an oil tanker carrying 55 million gallons of oil, struck a reef near the shore in Alaska’s Prince William Sound. The impact tore a hole in the side of the ship damaging the cargo tanks. By dawn, the slick of leaking black crude oil was eight miles long and was continuing to grow. According to a company representative the ship was in good repair, and the cause of the accident is under investigation.</p>
                                                </div>
                                            </div>
                                            <button id="tabOneAudioBtn" class="btn btn-primary btn-round">
						<i class="fa fa-play-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Play Audio
                                            </button>
					</div>
					<div class="tab-pane text-center" id="two">
					    <div class="card card-carousel">
						<div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false" >
						    <div class="carousel slide" data-ride="carousel">
							<!-- Wrapper for slides -->
							<div class="carousel-inner" style="min-width: 100%; height: 500px;">
							    <div class="item active">
								<div class="carousel-caption" style="top:0;margin-top: 1em;">
								    <button id="slideshowStart" class="btn btn-primary btn-block" style="padding-top: 1.5em;padding-bottom: 1.5em;height: ;">click to begin slide show with voiceover</button>
								</div>
							    </div>
							    <div class="item">
								<img src="images/stories/tabletone/tab2_1.png" alt="Awesome Image" style="min-width: 100%; height: 500px;">
								<div class="carousel-caption">
								    <h5>Within three days, the surface of Prince William Sound, a beautiful marine habitat with abundant sea life, was covered by heavy sheens of oil. Then, a storm hit.</h5>
								</div>
							    </div>
							    <div class="item">
								<img src="images/stories/tabletone/tab2_2.png" alt="Awesome Image" style="min-width: 100%; height: 500px;">
								<div class="carousel-caption">
								    <h5>The storm’s winds and high tides pushed large amounts of oil high up onto the rocky beaches and shores of islands and the coastline. Pools of black oil were stranded in the rocks.</h5>
								</div>
							    </div>
							    <div class="item">
								<img src="images/stories/tabletone/tab2_3.png" alt="Awesome Image" style="min-width: 100%; height: 500px;">
								<div class="carousel-caption">
								    <h5>Response to the emergency was difficult because Prince William Sound is a remote location, accessible only by helicopter, plane, or boat. By the time the leak was stopped, the oil covered 1,300 miles of coastline and 11,000 square miles of ocean.</h5>
								</div>
							    </div>
							    <div class="item">
								<img src="images/stories/tabletone/tab2_4.png" alt="Awesome Image" style="min-width: 100%; height: 500px;">
								<div class="carousel-caption">
								    <h5>Response teams tried using chemicals to disperse the oil and high pressure hot water hoses to clean up the shore, but they didn't work and caused even more damage to the plant and animal communities.</h5>
								</div>
							    </div>
							    <div class="item">
								<img src="images/stories/tabletone/tab2_5.png" alt="Awesome Image" style="min-width: 100%; height: 500px;">
								<div class="carousel-caption">
								    <h5>Orcas, seals, otters, bald eagles, hundreds of thousands of seabirds, shellfish and salmon, which flourished in this remote region, perished in the oil. Thirty years later, the ecosystem has still not fully recovered.</h5>
								</div>
							    </div>
							</div>
						    </div>
						</div>
					    </div>
					    <!-- End Carousel Card -->
					    <button id="previous" class="btn btn-simple" style="display:none;float:left;"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Previous</button>
              <button id="play" class="btn btn-primary btn-round" style="display:none;"><i class="fa fa-play-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Play Audio</button>
					    <!-- <button id="replay" class="btn btn-simple" style="display:none;"><i class="fa fa-undo" aria-hidden="true"></i></button> -->
					    <button id="pause" class="btn btn-simple" style="display:none;"><i class="fa fa-pause-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Pause Audio</button>
					    <!-- <button id="play" class="btn btn-simple" style="display:none;"><i class="fa fa-play" aria-hidden="true"></i></button> -->
					    <button id="next" class="btn btn-simple" style="display:none;float:right;">Next&nbsp;&nbsp;&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></button>
					    <!-- End Carousel Card -->
					</div>
					<!--<div class="tab-pane text-center" id="three">
					    <video style="width:100%;" src="./videos/tablet1_3.mp4" controls style="min-width:100%;"></video>
					</div>-->
					<div class="tab-pane" id="three">
                                            <style>.newspaper:after {
						background: linear-gradient(-45deg, #ffffff 8px, transparent 0), linear-gradient(45deg, #ffffff 8px, transparent 0);
						background-position: left bottom;
						background-repeat: repeat-x;
						background-size: 16px 16px;
						content: " ";
						display: block;
						position: absolute;
						bottom: 0px;
						left: 0px;
						width: 100%;
						height: 16px;
					     }</style>
                                            <div class="newspaper" style="position:relative;padding:0 0 32px 0;background-image: url('assets/img/paper-bkg.png');padding:1.3em;">
						<img src="images/stories/tabletone/tab4.png" class="img-responsive" style="margin-bottom:1em;">
						<h5>Exxon Valdez spill cleanup slow</h5>
						<div style="column-count:2;margin-bottom:2em;">
						    <h6><b>March 4, 1990</b></h6>
						    <p>In the report on the grounding of the Exxon Valdez, the National Transportation Safety Board revealed that at the time of the accident, Captain Joe Hazelwood was asleep in his cabin. Crew members reported that Captain Hazelwood had been drinking heavily and was drunk when boarding the ship. The ship was being steered out of port by third mate Gregory Cousins.  Before going to his cabin, Hazelwood directed Cousins to leave the shipping lane to avoid icebergs.  Cousins had worked a 22-hour shift loading oil before taking command. The RAYCAS radar system, which should have detected the reef was not turned on. Cousins realized the ship was close to the reef too late to make the turn back into the channel. Exxon representatives did not agree with crew members who said that the radar was broken, and felt it was too expensive to fix. </p>
                                                </div>
                                            </div>
                                            <button id="tabFourAudioBtn" class="btn btn-primary btn-round">
						<i class="fa fa-play-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Play Audio
                                            </button>
					</div>
          <div class="tab-pane" id="four">
              <form method="post">
                  <div class="row">
                      <div class="col-xs-offset-1 col-xs-10 col-sm-6 col-sm-offset-3">
                        <?php include 'add-group-member-button.php' ?>
                          <div class="form-group">
                              <input type="text" name="query" value="<?php echo $query; ?>" style="display: none">
                              <input type="text" name="resultRow" value="<?php echo $resultRow; ?>" style="display: none">
                              <label class="control-label" for="story"><h4>What is your story?</h4></label>
                              <select name="story" id="story" class="form-control input-lg" required>
                                <option value='0'>Story Number</option>;
                                <option value='1' <?php if($story==1) echo 'selected="selected"' ?> >Story 1: Grounded Tanker Spreads Destruction</option>;
                                <option value='2' <?php if($story==2) echo 'selected="selected"' ?> >Story 2: Google Replaces Facebook as Best Place to Work</option>;
                                <option value='3' <?php if($story==3) echo 'selected="selected"' ?> >Story 3: Explosion Rocks Space Program</option>;
                                <option value='4' <?php if($story==4) echo 'selected="selected"' ?> >Story 4: Near Miss for Nuclear Disaster</option>;
                                <option value='5' <?php if($story==5) echo 'selected="selected"' ?> >Story 5: School Start Times: It’s Too Early to Get Up!</option>;
                              </select>
                          </div>
                          <div class="form-group">
                                                      <label for="happen"><h4>What happened in the news story? (1-3 sentence summary)</h4></label>
                                                      <textarea class="form-control input-lg" id="id_happen" name="happen" placeholder="My response" rows="5"><?php echo $happen ?></textarea>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="factor"><h4>Who in the story had enough or not enough sleep? (one or more people)</h4></label>
                              <textarea class="form-control input-lg" id="id_factor" name="factor" placeholder="My response" rows="5"><?php echo $factor ?></textarea>
                                                  </div>

                                                  <div class="form-group">
                                                      <label for="affect"><h4>What were the effects of enough sleep and/or the lack of sleep  (decisions, actions, or performance)?</h4></label>
                                                      <textarea class="form-control input-lg" id="id_affect" name="affect" placeholder="My response" rows="5"><?php echo $affect ?></textarea>
                                                  </div>
                            </div>
                        </div>
              </form>
              <?php if($_SESSION['userType']=="student"){ ?>
      			<div class="row">
                                  <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
      				<a class="btn btn-success btn-large btn-block" href="#" onclick="submit()">Save &amp; Submit</a>
                                  </div>
      			</div>
      		    <?php }else{?>
      			<div class="row">
      			    <div class="col-xs-offset-1 col-xs-10 col-md-4 col-md-offset-4">
      				<a class="btn btn-success btn-large btn-block">Save &amp; Submit</a>
      			    </div>
      			</div>
      		    <?php } ?>
					</div>
				    </div>
				</div>
			    </div>
			</div>
		    </div>
                    <audio class="slideAudio" id="audioSlideOne" preload="auto" style="display: none;">
                        <source src='audio/tabtwo/tablet1tab2slide1.m4a' type='audio/mp4'>
                    </audio>
                    <audio class="slideAudio" id="audioSlideTwo" preload="auto" style="display: none;">
                        <source src='audio/tabtwo/tablet1tab2slide2.m4a' type='audio/mp4'>
                    </audio>
                    <audio class="slideAudio" id="audioSlideThree" preload="auto" style="display: none;">
                        <source src='audio/tabtwo/tablet1tab2slide3.m4a' type='audio/mp4'>
                    </audio>
                    <audio class="slideAudio" id="audioSlideFour" preload="auto" style="display: none;">
                        <source src='audio/tabtwo/tablet1tab2slide4.m4a' type='audio/mp4'>
                    </audio>
                    <audio class="slideAudio" id="audioSlideFive" preload="auto" style="display: none;">
                        <source src='audio/tabtwo/tablet1tab2slide5.m4a' type='audio/mp4'>
                    </audio>
                    <audio class="pageAudio" id="tabOneAudio" preload="auto" style="display:none;">
                        <source src='audio/tabone/tablet1tab1.m4a' type='audio/mp4'>
                    </audio>
                    <audio class="pageAudio" id="tabFourAudio" preload="auto" style="display:none;">
                        <source src='audio/tabfour/tablet1tab4.m4a' type='audio/mp4'>
                    </audio>
                </div>
            </div>
            <div class="modal fade" id="submit-modal" tabindex="-1" role="dialog" aria-labelledby="submit-modal-label" aria-hidden="true">
      		<div class="modal-dialog">
      		    <div class="modal-content">
      			<div class="modal-header">
      			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      			    <h4 class="modal-title" id="submit-modal-label">Submit the Activity?</h4>
      			</div>
      			<div class="modal-body">
      			    Are you ready to submit your work to your teacher?
      			</div>
      			<div class="modal-footer">
      			    <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Keep Working</button>
      			    <button id="submit-activity" type="button" class="btn btn-success btn-simple">Yes, Submit</button>
      			</div>
      		    </div>
      		</div>
      	    </div>
            <?php require 'partials/footer.php' ?>
        </div>
    </body>

    <script>
     $(function() {
        var defaultPlay = false;

         $("#next").click(function(){
             $("#carousel-example-generic").carousel('next');
         });

         $("#previous").click(function(){
             $("#carousel-example-generic").carousel('prev');
         });

         $('.slideAudio').on('ended', function() {
             $("#play").show();
             $("#pause").hide();
         });

         $('.slideAudio').on('playing', function() {
             $("#pause").show();
             $("#play").hide();
         });

         $("#pause").click(function(){
           defaultPlay = false;
             $(".slideAudio").trigger('pause');
             $("#play").show();
             $("#pause").hide();
         });

         $("#play").click(function(){
           defaultPlay = true;
             getSlideIndex();
             $("#play").hide();
             $("#pause").show();
         });

         $("#replay").click(function(){
             getSlideIndex();
         });

         $("#slideshowStart").click(function(){
             $("#carousel-example-generic").carousel(1);
             $("#next").show();
             $("#previous").show();
         });

         $("#carousel-example-generic").on('slid.bs.carousel', function () {
             $(".slideAudio").trigger('pause');
             $(".slideAudio").prop("currentTime",0);
             $("#replay").hide();
             $("#play").show();
             $("#pause").hide();
             getSlideIndex();

         })

         $("#tabOneAudioBtn").click(function(){

             var audio = $("#tabOneAudio");

             if (audio.get(0).paused) {
                 audio.trigger('play');
                 $("#tabOneAudioBtn").html('<i class="fa fa-pause-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Pause Audio');
             } else {
                 audio.trigger('pause');

                 $("#tabOneAudioBtn").html('<i class="fa fa-play-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Play Audio');
             }

         });

         $("#tabFourAudioBtn").click(function(){
             var audio = $("#tabFourAudio");

             if (audio.get(0).paused) {
                 audio.trigger('play');
                 $("#tabFourAudioBtn").html('<i class="fa fa-pause-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Pause Audio');
             } else {
                 audio.trigger('pause');

                 $("#tabFourAudioBtn").html('<i class="fa fa-play-circle" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;Play Audio');
             }
         });

         function getSlideIndex(){
             var active = $("#carousel-example-generic").find('.carousel-inner > .item.active');
             var from = active.index();
             $("#replay").hide();

             if (from == 0) {
                 $("#previous").hide();
                 $("#next").hide();
                 $("#pause").hide();
                 $("#play").hide();
             }

             if (from == 1) {
               if (defaultPlay) {
                 $("#audioSlideOne").trigger('play');
               }
             }
             else if (from == 2) {
               if (defaultPlay) {
                 $("#audioSlideTwo").trigger('play');
                 }
             }
             else if (from == 3) {
               if (defaultPlay) {
                 $("#audioSlideThree").trigger('play');
                 }
             }
             else if (from == 4) {
               $("#next").show();
               if (defaultPlay) {
                 $("#audioSlideFour").trigger('play');
                 }
             }
             else if (from == 5) {
               if (defaultPlay) {
                 $("#audioSlideFive").trigger('play');
                 }
                 $("#next").hide();
             }
         }

         $("a[data-toggle='tab']").click(function(){
             $("audio").trigger("pause");
             $("video").trigger("pause");
         });
     });




     function submit(){
	 if($("#story").val() == 0){
	     $.notify({
                 title: '<strong>Error:</strong>',
                 message: 'Please select your story number!'
             },{
                 placement: {
                     from: "top",
                     align: "center"
                 },
                 type: 'danger'
             }
             );
	 }else{
	     $('#submit-modal').modal('show');
	 }
     }

     $(function () {
         $("#exit-activity").click(function(){
             window.window.location.href = "fifth-grade-lesson-activity-menu?lesson=1&activity=1";
         });
         $("#save-activity").click(function(e) {
	     e.preventDefault();
             $.ajax({
                 url: 'worksheet-fifth-one-done',
                 method: 'POST',
                 data: $('form').serialize(),
                 success: (function() {
                     $.notify({
                         title: '<strong>Success!</strong>',
                         message: 'Your response has been saved, but has not been submitted.'
                     },{
                         placement: {
                             from: "top",
                             align: "center"
                         },
                         type: 'success'
                     }
                     );
                 }),
                 error:(function(XMLHttpRequest, textStatus, errorThrown){
                     $.notify({
                         title: '<strong>Error:</strong>',
                         message: 'Your work was not saved. Please contact your teacher<br>Code: ' + errorThrown
                     },{
                         placement: {
                             from: "top",
                             align: "center"
                         },
                         type: 'danger'
                     }
                     );
                 })
             });
         });


         $("#submit-activity").click(function() {

             var input = $("<input>")
                 .attr("type", "hidden")
                 .attr("name", "btnSubmit").val("1");
             $('form').append($(input));
	     $("form").attr("action", "worksheet-fifth-one-done")
             $('form').submit();
         });
     });
    </script>
</html>
