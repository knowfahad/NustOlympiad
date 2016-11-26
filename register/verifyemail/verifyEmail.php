<?php
//a get request will be made to this script for verification. Test the hardcoded value for now! if true, echo true, else echo invalid request
  include_once '../../OlAssets/dbconnect.php';

//get username and code from url
 $URLusername = strip_tags($_GET["Username"]);;  
 $URLcode = strip_tags($_GET["ActivationCode"]);
  
  //get activation code of user from db
  /* create a prepared statement */
	if ($stmt = $conn->prepare("SELECT ActivationCode FROM useraccount WHERE Username =?")) {

		/* bind parameters for markers */
		$stmt->bind_param("s", $URLusername);

		/* execute query */
		$stmt->execute();
		$result = $stmt->get_result();

		//if username exists! 
	

		if(mysqli_num_rows($result) > 0) {
			$row=mysqli_fetch_array($result,MYSQLI_NUM);
			//check if query result matches URL Code
			if($row[0]== $URLcode){
	

				//On match update 
				if ($stmt = $conn->prepare("UPDATE useraccount SET AccountStatus=1 WHERE Username =?")) {

					/* bind parameters for markers */
					$stmt->bind_param("s", $URLusername);

					/* execute query */
					$stmt->execute();
					echo "match updated";
				}
				else {

					echo "\nActivation code does not match, please check again!";
				}

			/* free results */
			$stmt->free_result();
			/* close statement */
			$stmt->close();
			
			//return error
			exit();
		}
	}
		
		/* free results */
		$stmt->free_result();
		/* close statement */
		$stmt->close();
	}
?>