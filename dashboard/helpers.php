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
use PDO;
require_once(__DIR__."/../bootstrap.php");


function getChallans($auth, $conn){
	$stmt = $conn->prepare(
<<<epquery
select 		e.Name, e.EventType, e.EventFee, challan.DueDate, challan.ChallanID, challan.PaymentStatus
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
		$stmt->execute([$cnic]);
		return ($stmt->fetchAll(PDO::FETCH_ASSOC));
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
	$stmt->execute([$cnic]);
	$challans = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
	$stmt->execute([$cnic]);
	$challans = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if(!$challans)
		return false;
	return $challans[0];
}

function enrolledTeams($auth, $conn){
	$teams = [];
	$teamids = [];
	$stmt = $conn->prepare("
		select sp.TeamID
		from sportsparticipants as sp
		inner join sportsteam as st
		on sp.TeamID = st.TeamID
		inner join challan as ch
		on ch.ChallanID = st.ChallanID
		where sp.ParticipantID = ? AND ch.PaymentStatus = 1");
	$ParticipantID = $auth->getParticipant()->getParticipantID();
	$stmt->execute([$ParticipantID]);
	$stmt->bindColumn(1, $tempteamid);
	while($stmt->fetch(PDO::FETCH_BOUND)){
		$teamids[] = $tempteamid;
	}
	foreach($teamids as $teamid){
		if($nstmt = $conn->prepare("select * from sportsteam where TeamID = ?")){
			$nstmt->execute([$teamid]);
			$teams = $nstmt->fetchAll(PDO::FETCH_CLASS, Team::class, [$auth, $conn]);
		}
		else
			var_dump($conn->error);
	}
	return ($teams);	
}

function teamChallans($auth, $conn){
	$stmt = $conn->prepare("
		select st.TeamName, ch.ChallanID, ch.AmountPayable, ch.DueDate, ch.PaymentStatus
		from sportsteam as st
		inner join challan as ch
		on st.ChallanID = ch.ChallanID
		where st.HeadCNIC = ?");
	$stmt->execute([$auth->getCNIC()]);

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



 ?>
