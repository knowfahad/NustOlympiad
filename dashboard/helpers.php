<?php 
namespace Dashboard;

use App\Team;
use Model\Model\ChallanQuery;
use Model\Model\EventparticipantsQuery;
use Model\Model\EventsQuery;
use Model\Model\Sportsparticipants;
use Model\Model\SportsparticipantsQuery;
use Model\Model\Sportsteam;
use Model\Model\SportsteamQuery;
require_once(__DIR__."/../bootstrap.php");


function getChallans($auth, $conn){
	$stmt = $conn->prepare(
<<<epquery
select 		e.Name, e.EventType, e.EventFee, challan.DueDate, challan.ChallanID, ep.PaymentStatus
from    	eventparticipants as ep
inner join 	events as e
on 			e.EventID = ep.EventID
inner join 	challan
on 			challan.ChallanID = ep.ChallanID
where 		ep.ParticipantCNIC = ?
epquery
);
	try{

		$cnic = $auth->getParticipant()->getCNIC();
		$stmt->bind_param('s', $cnic);
		$stmt->execute();
		// echo $stmt->error;
		return ($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
	}
	catch(Exception $e){
		var_dump($e);
	}
}

function accomodationChallan($auth, $conn){
	$cnic = $auth->getCNIC();
	$query = <<<epquery
	select 	challan.ChallanID, challan.DueDate, challan.AmountPayable, challan.PaymentStatus
	from 	challan
	where 	challan.ChallanID = (
			select 	AccomodationChallanID 
			from 	participant
			where 	participant.CNIC = ?
	)
epquery;
	$stmt = $conn->prepare($query);
	$stmt->bind_param("s",$cnic);
	$stmt->execute();
	$challans = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	if(!$challans)
		return false;
	return $challans[0];
}

function registrationChallan($auth, $conn){
	$cnic = $auth->getCNIC();
	$query = <<<epquery
	select 	challan.ChallanID, challan.DueDate, challan.AmountPayable, challan.PaymentStatus
	from 	challan
	where 	challan.ChallanID = (
			select 	RegistrationChallanID 
			from 	participant
			where 	participant.CNIC = ?
	)
epquery;
	$stmt = $conn->prepare($query);
	$stmt->bind_param("s",$cnic);
	$stmt->execute();
	$challans = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	if(!$challans)
		return false;
	return $challans[0];
}

function enrolledTeams($auth, $conn){
	$teams = [];
	$teamids = [];
	$stmt = $conn->prepare("select TeamID from sportsparticipants where ParticipantID = ?");
	$ParticipantID = $auth->getParticipant()->getParticipantID();
	$stmt->bind_param("i", $ParticipantID);
	$stmt->execute();
	$stmt->bind_result($tempteamid);
	while($stmt->fetch()){
		$teamids[] = $tempteamid;
	}
	foreach($teamids as $teamid){
		if($nstmt = $conn->prepare("select * from sportsteam where TeamID = ?")){
			$nstmt->bind_param("i", $teamid);
			$nstmt->execute();
			$teams[] = $nstmt->get_result()->fetch_object(Team::class, [$auth, $conn]);
		}
		else
			var_dump($conn->error);
	}
	return ($teams);	
}

 ?>