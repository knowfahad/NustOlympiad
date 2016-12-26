<?php 
namespace Dashboard;

use Model\Model\ParticipantQuery;
use Model\Model\UseraccountQuery;
require(__DIR__ . '/../bootstrap.php');
if(isset($_POST['id'])){

	$user = ParticipantQuery::create()->filterByParticipantID($_POST['id'])->findOne();
	if($user)
		echo $user->toJson();
	else{
		http_response_code(404);
		echo json_encode(0);
		exit(404);
	}
}