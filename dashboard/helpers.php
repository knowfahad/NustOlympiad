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


 ?>