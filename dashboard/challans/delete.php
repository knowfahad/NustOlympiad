<?php 
require_once(__DIR__.'/../../bootstrap.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$cnic = $auth->getCNIC();
	$challanid = $_POST['challanid'];
	$stmt = $mpdo->prepare("select * from eventparticipants where ChallanID = ? AND ParticipantCNIC = ?");
	if(!$stmt->execute([$challanid, $cnic])){
		die("there was an error!");
	}
	$stmt = $mpdo->prepare("delete from challan where ChallanID = ?");
	$stmt->execute([$challanid]);
}
else
	echo "no submission";
\App\redirect("/dashboard");