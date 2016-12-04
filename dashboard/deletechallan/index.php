<?php 
namespace Dashboard;
require_once('../bootstrap.php');

if($auth->loggedIn()){
	\App\redirect("/dashboard");
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$cnic = $auth->getCNIC();
	$challanid = $_POST['challanid'];
	$stmt = $conn->prepare("delete from eventparticipant where ChallanID = ? AND ParticipantCNIC = ?");
	$stmt->bind_param("ss", $challanid, $cnic);
	$stmt->execute();
}
\App\redirect("/dashboard");