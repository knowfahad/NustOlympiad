<?php 
require_once(__DIR__.'/../../bootstrap.php');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$cnic = $auth->getCNIC();
	$challanid = $_POST['challanid'];
	$stmt = $conn->prepare("select * from eventparticipants where ChallanID = ? AND ParticipantCNIC = ?");
	$stmt->bind_param("ss", $challanid, $cnic);
	if(!$stmt->execute()){
		die("there was an error!");
	}
	$stmt->close();
	$stmt = $conn->prepare("delete from challan where ChallanID = ?");
	$stmt->bind_param("s", $challanid);
	$stmt->execute();
}
else
	echo "no submission";
\App\redirect("/dashboard");