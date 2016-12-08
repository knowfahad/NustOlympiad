<?php 
require("bootstrap.php");
$auth->onlyLoggedIn();
$teams = \Dashboard\enrolledTeams($auth, $conn);
foreach($teams as $team){
	var_dump($team->challan());
}