<?php 
namespace Dashboard;

use Model\Model\ParticipantQuery;
use Model\Model\UseraccountQuery;
require(__DIR__ . '/../bootstrap.php');

if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(!isset($_POST['id'])){
		echo json_encode(false);
		exit();
	}
	$user = ParticipantQuery::create()->filterByParticipantID(1487)->findOne();
	// if(!$user){
	// 	echo json_encode(false);
	// 	exit();
	// }
	echo $user->toJson();
}
