<?php 
namespace Dashboard;

use Model\Model\ParticipantQuery;
use Model\Model\UseraccountQuery;
require(__DIR__ . '/../bootstrap.php');

if(!isset($_POST['id'])){
	echo json_encode(false);
	exit();
}
$user = ParticipantQuery::create()->filterByParticipantID($_POST['id'])->findOne();

echo $user->toJson();
