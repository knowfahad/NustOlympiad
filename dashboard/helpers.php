<?php 
namespace Dashboard;

use Model\Model\ChallanQuery;
use Model\Model\EventparticipantsQuery;
use Model\Model\EventsQuery;
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
	return $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
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
	return $stmt->get_result()->fetch_all(MYSQLI_ASSOC)[0];
}

 ?>