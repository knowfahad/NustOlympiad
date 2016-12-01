<?php 
require("./OLAssets/dbconnect.php");

$nextid = $conn->query("select max(`ParticipantID`) as max from `participant`")
		->fetch_object()
		->max + 1;
var_dump($nextid);
?>
