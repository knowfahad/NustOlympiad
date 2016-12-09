<?php
//a get request will be made to this script for verification. Test the hardcoded value for now! if true, echo true, else echo invalid request
  include_once '../../OlAssets/dbconnect.php';

//get username and code from url
 $URLusername = strip_tags($_GET["Username"]);;  
 $URLcode = strip_tags($_GET["ActivationCode"]);
  
  //get activation code of user from db
  /* create a prepared statement */
	if ($stmt = $mpdo->prepare("SELECT ActivationCode FROM useraccount WHERE Username =?")) {

		/* bind parameters for markers */
		/* execute query */
		$stmt->execute([$URLusername]);
		if($stmt->rowCount() > 0) {
			$row=$stmt->fetchAll(PDO::FETCH_NUM);
			//check if query result matches URL Code
			if($row[0]== $URLcode){
	

				//On match update 
				if ($stmt = $mpdo->prepare("UPDATE useraccount SET AccountStatus=1 WHERE Username =?")) {
					$stmt->execute([$URLusername]);
					echo "match updated";
				}
				else {

					echo "\nActivation code does not match, please check again!";
				}
			}
		}
	}
?>