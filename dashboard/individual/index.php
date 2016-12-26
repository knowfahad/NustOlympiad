<?php 
namespace Dashboard;
require(__DIR__ . '/../../bootstrap.php');
use PDO;
use Model\Model\AmbassadorParticipant;
use Model\Model\AmbassadorQuery;
use Model\Model\Challan;
use Model\Model\Eventparticipants;
use Model\Model\EventparticipantsQuery;
use Model\Model\EventsQuery;
//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();
$auth->onlyVerified();

//find the list of events to display
$stmt = $mpdo->prepare("select e.EventID, e.Name from events as e where e.EventType = 1 and e.EventID not in (select ep.EventID from eventparticipants as ep where ep.ParticipantCNIC = ?)");
$cnic = $auth->getParticipant()->getCNIC();
$stmt->execute([$cnic]);
$eventlist = $stmt->fetchAll(PDO::FETCH_ASSOC);


//process the form if it was submitted
$formsubmitted = $_SERVER['REQUEST_METHOD'] == 'POST';
if($formsubmitted){
	$eventname = $_POST['eventname'];

	if(!strlen($eventname)){
		$error = "Please select on option!";
	}
	else{
		$stmt = $mpdo->prepare("select e.EventID from eventparticipants as e where e.EventID = ?");
		$stmt->execute([$eventname]);
		if($stmt->rowCount())
			$error = "You have already participated in this event!";
	}
	if(!isset($error)){
		$event = EventsQuery::create()->filterByEventId($eventname)
						->filterByEventType(1)
						->findOne();
		if(strlen($_POST['ambassador_id'])){
			$ambassador_id = $_POST['ambassador_id'];
			$ambassador = AmbassadorQuery::create()
							->filterByAmbassadorID($ambassador_id)
							->findOne();
			if(!$ambassador){
				$error = "The Ambassador ID doesn't exist";
			}
		}
		if(!$event){
			$error = "Please select a valid event!";
		}
		if(!isset($error)){
			//first generate challan
			$participant = $auth->getParticipant();
			$challanid = "IC"
						.$participant->getParticipantID()
						."E"
						.$event->getEventID();
			$challan = new Challan();
			$challan->setChallanID($challanid);
			$challan->setAmountPayable($event->getEventFee());
			$challan->setDueDate("10-10-2016");
			$challan->setPaymentStatus(0);
			$challan->save();
			//then add a row in the eventsparticipants table 
			$ep = new Eventparticipants;
			$ep->setParticipantCNIC($participant->getCNIC());
			$ep->setEventID($event->getEventID());
			$ep->setChallanID($challanid);
			$ep->setPaymentStatus(0);
			$ep->setDueDate("10-10-2016");
			$ep->save();
			//add a row in ambassador_participant if ambassador_id provided
			if(isset($ambassador)){
				$stmt = $mpdo->prepare("insert into ambassador_participant(ParticipantID, AmbassadorID, EventID, ChallanID) values(?,?,?,?)");
				$stmt->execute([$auth->getParticipant()->getParticipantID(), $ambassador->getAmbassadorID(), $event->getEventID(), $challanid]);
				// $ap = new AmbassadorParticipant();
				// $ap->setParticipantID($participant->getParticipantID());
				// $ap->setAmbassadorID($ambassador->getAmbassadorID());
				// $ap->setEventID($event->getEventID());
				// $ap->setChallanID($challanid);
				// $ap->save();
			}
			\App\redirect("/dashboard?feedback=event");
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | NUST Olympiad '17</title>
    <link rel="stylesheet" type="text/css" href="/css/timeline.css">
    <link rel="stylesheet" href="/css/themify-icons.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel='stylesheet' href='/css/perfect-scrollbar.min.css' />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/buttons.css" />
    <link rel="stylesheet" href="/css/animate.css" />
    <link rel="stylesheet" href="/css/tooltip.css" />
    <link rel="stylesheet" href="/css/demo3.css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="/css/style2.css" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Sports | NUST Olympiad '17</title>
    <!--<script type="text/javascript" async="" src="Register_files/recaptcha__en.js"></script><script src="Register_files/jquery.js"></script> -->
    <!-- <script src="https://maxdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <!--<script src="Register_files/api.js"></script> -->
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script> -->

<script type="text/javascript">
var IndividualEventsList = ["None","Funkaar","Pair’em Up","Hurdle Marathon","Wall Climbing","Archery","Air-Gun Shooting",
"Nose Dive","Minute to win it","Live Charcoal","Pakistan Got Talent","Table Tennis(Males)","Table Tennis(Females)",
"Badminton(Males)","Badminton(Females)","Chess","Squash(Males)","Squash(Females)","FIFA","Need for Speed: Most Wanted","Short Put","Long Jump",
"100 Meters Race(Males)","100 Meters Race(Females)","200 Meters Race(Males)","200 Meters Race(Females)",
"4*100 Meters Relay(Males)","4*100 Meters Relay(Females)","4*200 Meters Relay(Males)","4*200 Meters Relay(Females)","Essay Writing Competition","Who wants to be a millionaire"];
$(document).ready(function()
{
	$(document).on("click", ".btn", function () {
	    
		 var id = $(this).attr('id');
		 $("#eventname").val(id);
		 
		 $(".modal-title").html( 'Register for ' + IndividualEventsList[id]);
		 
});
});

</script>
    <style>
        a {
            color: white;
        }
        
        a:hover,
        a:focus {
            color: white;
        }
        
        input {
            color: white;
        }
        
        label {
            font-weight: normal;
        }
        
        .col-centered {
            float: none;
            margin: 0 auto;
        }
        
        .my-box {
            border-style: solid;
            border-color: white;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-width: 1px;
            padding: 2%;
        }
        .my-btn
        {
            background-color: transparent;
            color:white;
            border-radius: 0 !important;

        }
        input
        {
            width: 90%;
        }
    </style>
</head>

<body id="id-body">
<!-- Modal -->
					  <div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">
						
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Modal Header</h4>
							</div>
							<div class="modal-body">
							  
							  <h4>Details:</h4>
							  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
							  consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
							  cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
							  proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
							  <hr>
							  <form method="POST">
							  	<input id="eventname" type="hidden" name="eventname">
							  	<div class="form-group">
							  		<label class="control-label">Ambassador ID(optional)</label>
							  		<input class="form-control" type="text" placeholder="Ambassador ID(optional)" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ambassador ID(optional)'"  name="ambassador_id">
							  	</div>	
							  	<button type="submit">Apply!</button>							
							  </form>
							</div>
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						  </div>
						  
						</div>
					  </div>
    <div class="td-preloading">
        <span class="fa fa-spinner fa-spin"></span>
    </div>
    <div class="td-container">
        <!--<div class="row">
        <div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2  col-sm-4 col-sm-offset-4">
            <img src="/img/cube.png" alt="" style="margin-bottom:0;">
        </div>
    </div>-->
        <div class="td-sheets-container td-hide td-sheet-active-1">
            <div class="row">
            </div>
            <div id="scrollbar-container" class="td-sheet active">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3 col-centered col-sm-3">
                           
                                <img src="/img/logo.png" class="img-responsive" alt="LOGO" />
                            
                        </div>
                    </div>
                    <div class="row homepage">
                        
                    <div class="row">
                        <div class="col-md-10 col-xs-5 col-sm-7"></div>
                        <div class="col-md-2 col-xs-7 col-sm-5">
                            <div id="userId">
                                <p style="display:inline;color:orange;">User Id:<?=$auth->getParticipant()->getParticipantID()?></p><span> | </span><a href="#">Logout</a></div>
                        </div>
                        <hr>
                    </div>
						
                    <div class="row">
                      <div class = "col-md-1"></div>
                            <div class="col-md-12 my-box ">
                            	<div class="row">
	            					<?php if( $formsubmitted && isset($error) ): ?>
	                                    <div class="col-md-10 col-md-offset-1 col-xs-12">
	                                        <div class="container-fluid">
	                                <div  id =  'errorShow' class = "alert alert-danger">
	                                <!--append errors here! -->
	                                    <div class="row">&nbsp;<?=$error?></div>
	                                </div>
	                                </div></div>
	                                <?php endif ?>
                            	</div>
                                <h4 style="text-align:left;">Select an Event</h4>
                                <br>
								<br>
                                <!--new -->
                                <div class="row">
                                    <div class = "col-md-2 col-xs-3"></div>
									<div class = "col-md-8 col-xs-6">
									<center>
                                            <!--new start-->
                                            <div class = "row">
                                                <div class = "col-md-4">
											<input type="button" id = "1" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Funkaar" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "2" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Pair’em Up" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "3" data-toggle="modal" data-target="#myModal"  class="btn btn-default btn-sm my-btn" value="Hurdle Marathon" />
										</div>
										
                                                </div>
									<br>
                                            <!--new-->
                                        
									<div class = "row">
										
										<div class = "col-md-4">
											<input type="button" id = "4" data-toggle="modal" data-target="#myModal" class="btn btn-default btn-sm my-btn" value="Wall Climbing" />
										</div>
                                        <div class = "col-md-4">
											<input type="button" id = "5" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Archery" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "6" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Air-Gun Shooting" />
										</div>
										
									
									</div>
									<br>
									<div class = "row">
									
										
										<div class = "col-md-4">
											<input type="button" id = "7" class="btn btn-default btn-sm my-btn" value="Nose Dive" data-toggle="modal" data-target="#myModal"  />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "8" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Minute to win it" />
										</div>
                                        <div class = "col-md-4">
											<input type="button" id = "9" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Live Charcoal" />
										</div>
									
									
									</div>
                                    <br>

                                    <div class = "row">
									
										
										<div class = "col-md-4">
											<input type="button" id = "10" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Pakistan Got Talent" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "11" class="btn btn-default btn-sm my-btn" value="Table Tennis(Males)" data-toggle="modal" data-target="#myModal"  />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "12" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Table Tennis(Females)" />
										</div>
									
									
									</div>
                                    <br>

                                    <div class = "row">
									
										<div class = "col-md-4">
											<input type="button" id = "13" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Badminton(Males)" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "14" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Badminton(Females)" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "15" class="btn btn-default btn-sm my-btn" value="Chess" data-toggle="modal" data-target="#myModal"  />
										</div>
										
									
									
									</div>
                                    <br>
                                     <div class = "row">
                                         <div class = "col-md-4">
											<input type="button" id = "16" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Squash(Males)" />
										</div>
                                        <div class = "col-md-4">
											<input type="button" id = "17" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Squash(Females)" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "18" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="FIFA" />
										</div>
                                         </div>
                                    <br>

                                     <div class = "row">
									
										
										<div class = "col-md-4">
											<input type="button" id = "19" class="btn btn-default btn-sm my-btn" value="Need for Speed: Most Wanted" data-toggle="modal" data-target="#myModal"  />
										</div>
                                             <div class = "col-md-4">
											<input type="button" id = "20" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Short Put" />
										</div>
                                        

										<div class = "col-md-4">
											<input type="button" id = "21" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Long Jump" />
										</div>
										
									
									
									</div>
                                    <br>

                                    <div class = "row">
                                        
                                       
										<div class = "col-md-4">
											<input type="button" id = "22" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="100 Meters Race(Males)" />
										</div>
                                        <div class = "col-md-4">
											<input type="button" id = "23" class="btn btn-default btn-sm my-btn" value="100 Meters Race(Females)" data-toggle="modal" data-target="#myModal"  />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "24" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="200 Meters Race(Males)" />
										</div>
									
									
									</div>
                                    <br>
                                     <div class = "row">
                                    <div class = "col-md-4">
											<input type="button" id = "25" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="200 Meters Race(Females)" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "26" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="4*100 Meters Relay(Males)" />
										</div>
                                        <div class = "col-md-4">
											<input type="button" id = "27" class="btn btn-default btn-sm my-btn" value="4*100 Meters Relay(Females)" data-toggle="modal" data-target="#myModal"  />
										</div>
                                        </div>
                                    <br>

                                    
                                    
                                    

                                    <div class = "row">
                                        <div class = "col-md-4">
											<input type="button" id = "28" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="4*200 Meters Relay(Males)" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "29" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="4*200 Meters Relay(Females)" />
										</div>
										<div class = "col-md-4">
											<input type="button" id = "30" class="btn btn-default btn-sm my-btn" data-toggle="modal" data-target="#myModal"  value="Essay Writing Competition" />
										</div>
										
									
									
									</div>
                                    <br>
                                     <div class = "row">
                                    <div class = "col-md-4">
											<input type="button" id = "31" class="btn btn-default btn-sm my-btn" value="Who wants to be a millionaire" data-toggle="modal" data-target="#myModal"  />
										</div>
                                        </div>
                                    <br>

									</center>
									</div>
									<div class = "col-md-2 col-xs-3"></div>
                                </div>
                                <!--new-->
                            </div>
					  <div class = "col-md-1"></div>
                     
                    </div>
                    <br>
                    <br>

					
                    
                </div>
            </div>
			
					  

            <script src="/js/jquery.min.js"></script>
            <script src="/js/responsive.js"></script>
            <script src="/js/perfect-scrollbar.min.js"></script>
            <script src="/js/bootstrap.min.js"></script>
            <script src="/js/jquery.visible.min.js"></script>
            <script src="/js/scriptdemo3.js"></script>
            <script src="/js/detectanimation.js"></script>

</body>

</html>