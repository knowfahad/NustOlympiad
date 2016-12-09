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
//find the list of events to display
$stmt = $mpdo->prepare("select e.EventID, e.Name from events as e where e.EventType = 1 and e.EventID not in (select ep.EventID from eventparticipants as ep where ep.ParticipantCNIC = ?)");
$cnic = $auth->getParticipant()->getCNIC();
$stmt->execute([$cnic]);
$eventlist = $stmt->fetchAll(PDO::FETCH_ASSOC);


//process the form if it was submitted
if($_SERVER['REQUEST_METHOD'] == 'POST'){
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
				$ap = new AmbassadorParticipant();
				$ap->setParticipantCNIC($participant->getCNIC());
				$ap->setAmbassadorID($ambassador->getAmbassadorID());
				$ap->setEventID($event->getEventID());
				$ap->save();
			}
			\App\redirect("/dashboard");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Individual Events | NUST Olymiad '17</title>
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
</head>
<body>
	<?php if(isset($error)): ?>
	<div class="alert-danger">
		<?=$error?>
	</div>
	<?php endif ?>
	<?php if(count($eventlist)): ?>
	<h2>Select an event you wish to participate in</h2>
	<form method="POST">
		<?php foreach($eventlist as $event):?>
		<div class="form-group">
			<label>
				<input type="radio" name="eventname" value="<?=$event['EventID']?>">
				<?=$event['Name']?>
			</label>
		</div>
		<?php endforeach ?>
	<div class="form-group">
		<label class="control-label">Ambassador ID(optional)</label>
		<input class="form-control" type="number" name="ambassador_id">
	</div>
	<hr>
	<button type="submit" >Apply!</button>
	</form>
	<?php else: ?>
	<h2>You have already applied in all events<h2>
	<?php endif ?>

</body>
</html>