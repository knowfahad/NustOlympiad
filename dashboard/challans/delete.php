<?php 
require_once(__DIR__.'/../../bootstrap.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$cnic = $auth->getCNIC();
	$challanid = $_POST['challanid'];
	$stmt = $conn->prepare("delete from eventparticipants where ChallanID = ? AND ParticipantCNIC = ?");
	$stmt->bind_param("ss", $challanid, $cnic);
	if(!$stmt->execute()){
		var_dump("there was an error!");
	}
}
\App\redirect("/dashboard");