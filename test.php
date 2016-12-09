<?php 
require("bootstrap.php");

	$username = "adamsmith";
 	if ($stmt = $mpdo->prepare("SELECT * FROM useraccount WHERE Username =?")) {
	 	$stmt->execute([$username]);
	 	if($stmt->rowCount() > 0) {
	 		
	 		//return error
	 		echo ("username already exists!");
	 	}
 	}

