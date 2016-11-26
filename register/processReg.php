<?php
  ///WILL BE USING AJAX REQUESTS FOR THIS SCRIPT!
	//Populate challan table first! Key constraints
	
  include_once '../OlAssets/dbconnect.php';
  include_once 'random_compat-master/lib/random.php';
 
  //rand string generator!
  
  $length = 8;
  $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  
    $acCode = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $acCode .= $keyspace[random_int(0, $max)];
    }
    
  
  $username = strip_tags($_POST["username"]);;  
  $cnic = strip_tags($_POST["cnic"]);
  $email = strip_tags($_POST["email"]);
  $pwd = strip_tags($_POST["pwd"]);
  $repwd = strip_tags($_POST["repwd"]);  
  $gender = "";
  
  $nustid = "NON_NUSTIAN";
  $ambassador_id = "0";
  
  $phone = strip_tags($_POST["mobile"]);
  $fname = strip_tags($_POST["fname"]);
  $lname = strip_tags($_POST["lname"]);
  $mobile = strip_tags($_POST["mobile"]);
  $address = strip_tags($_POST["address"]);
  $isNustian = strip_tags($_POST["isNustian"]);
  $ambassador = strip_tags($_POST["ambassador"]);  
  $isAmbassador = false;
  
  if($pwd != $repwd){
	  //return an error! 
		echo "Passwords dont match!";
		exit();
  }
  
  //check if username already exists!
  /* create a prepared statement */
	if ($stmt = $conn->prepare("SELECT * FROM useraccount WHERE Username =?")) {

		/* bind parameters for markers */
		$stmt->bind_param("s", $username);

		/* execute query */
		$stmt->execute();
		$result = $stmt->get_result();

		//if username already exists! 
		
		if(mysqli_num_rows($result) > 0) {
			/* free results */
			$stmt->free_result();
			/* close statement */
			$stmt->close();
			
			//return error
			echo "username already exists!";
			exit();
		}
		
		/* free results */
		$stmt->free_result();
		/* close statement */
		$stmt->close();
	}
  //check if nic exists
  
  /* create a prepared statement */
	if ($stmt = $conn->prepare("SELECT * FROM participant WHERE CNIC =?")) {

		/* bind parameters for markers */
		$stmt->bind_param("s", $cnic);

		/* execute query */
		$stmt->execute();
		$result = $stmt->get_result();

		//if cnic already exists! 
		
		if(mysqli_num_rows($result) > 0) {
			/* free results */
			$stmt->free_result();
			/* close statement */
			$stmt->close();
			
			//return error
			echo "CNIC already exists!";
			exit();
		}
		
		/* free results */
		$stmt->free_result();
		/* close statement */
		$stmt->close();
	}
    
  //check if email already exists
  if ($stmt = $conn->prepare("SELECT * FROM useraccount WHERE Email =?")) {

		/* bind parameters for markers */
		$stmt->bind_param("s", $email);

		/* execute query */
		$stmt->execute();
		$result = $stmt->get_result();

		//if email already exists! 
		
		if(mysqli_num_rows($result) > 0) {
			/* free results */
			$stmt->free_result();
			/* close statement */
			$stmt->close();
			
			//return error
			echo "email already exists!";
			exit();
		}
		
		/* free results */
		$stmt->free_result();
		/* close statement */
		$stmt->close();
	}
  
  if (isset($_POST['gender'])) {
    
	 $gender = $_POST['gender'];
  }
  else{
	  	  //echo error that gender is not selected
	  echo("Select your gender please!");
  }
  
  if($isNustian == "n_yes"){
	  $nustid = $_POST["nustid"];
  }
  
  if($ambassador == "a_yes"){
	  $ambassador_id = $_POST["ambassadorID"];
		$isAmbassador = true;
		 
	  //check whether the ambassador exists in database. Else return error!
	  
	  if ($stmt = $conn->prepare("SELECT * FROM Ambassador WHERE AmbassadorID =?")) {

			/* bind parameters for markers */
			$stmt->bind_param("s", $ambassador_id);

			/* execute query */
			$stmt->execute();
			
			$result = $stmt->get_result();

			//if abassador id DOES NOT exist!
			
			if(mysqli_num_rows($result) == 0) {
				//return error
				/* free results */
				$stmt->free_result();
				/* close statement */
				$stmt->close();
				
				//return error
				echo "Ambassador id doesnot exist!";
				exit();
			}
			
			/* free results */
			$stmt->free_result();
			/* close statement */
			$stmt->close();
		}
		
	  
  }
  //image handling part here!

  //if everything alright! proceed!
  
  //Populate challan table first!
  
  //create reg Challan and account Ac Code
  
    $regChallan = "RC";
    $regChallan .= $cnic;
	
	
    if($stmt = $conn->prepare("INSERT INTO challan (ChallanID, AmountPayable, DueDate, PaymentStatus) VALUES (?,?,?,?)")){
		$date= '20170101';
		$am = 1000;
		$s= 0;
		$stmt->bind_param("sisi", $regChallan,$am,$date, $s);
		
		$stmt->execute();
		
		$stmt->close();
	}
	else{
		echo("\ninsert challan not executed!\n");
	}
	//insert into participant
	
	if($isAmbassador == true){
		if($stmt = $conn->prepare("INSERT INTO participant (CNIC,FirstName,LastName,Gender,Address,PhoneNo, RegistrationChallanID,NUSTRegNo,AmbassadorID) VALUES (?,?,?,?,?,?,?,?,?)")){

		
		
		$stmt->bind_param("sssssssss", $cnic, $fname, $lname, $gender, $address, $phone, $regChallan,$nustid, $ambassador_id);
		
		$stmt->execute();
		
		echo $stmt->error;
		$stmt->close();
		}
		else{
			echo("\ninsert into participant not executed!\n");
		}
	
	}
	else{
		if($stmt = $conn->prepare("INSERT INTO participant (CNIC,FirstName,LastName,Gender,Address,PhoneNo, RegistrationChallanID,NUSTRegNo) VALUES (?,?,?,?,?,?,?,?)")){

		
		
		$stmt->bind_param("ssssssss", $cnic, $fname, $lname, $gender, $address, $phone, $regChallan,$nustid);
		
		$stmt->execute();
		
		echo $stmt->error;
		$stmt->close();
		}
		else{
			echo("\ninsert participant not executed!\n");
		}
		
	}
	// insert into account!
	
	if($stmt = $conn->prepare("INSERT INTO useraccount (username, ParticipantCNIC,Email,Password, AccountStatus, ActivationCode,ResetCode) VALUES (?,?,?,?,?,?,?)")){

		$rCode= 'Null';
		$status = 0;
		$stmt->bind_param("ssssiss", $username,$cnic,$email, $pwd, $status, $acCode, $rCode);
		
		$stmt->execute();
		echo('values Inserted!');
		echo $stmt->error;
		$stmt->close();
	}

  
  //Hira's code:  use $acCode variable
  require_once 'PHPMailer-master/PHPMailerAutoload.php';
$m= new PHPMailer;
$m->isSMTP();
$m->SMTPAuth=true;

$m->Host='smtp.gmail.com';
$m->Username='nustolympiad17@gmail.com';
$m->Password='nustnust';
$m->SMTPSecure='ssl';
$m->Port=465;


$m->From='nustolympiad17@gmail.com';
$m->FromName='nust olympiad 17';
$m->addReplyTo('nustolympiad17@gmail.com', 'Nust');
$m->addAddress("$email", "$fname");

$message = "To verify your account click on the link:  
http://localhost/tempScripts/register/verifyemail/verifyEmail.php?Username=$username&ActivationCode=$acCode";

$m->Subject='Verify your account | NUST OLYMPIAD 17';
$m->Body=$message;

if( $m->send()) {
echo "\nPlease confirm email!";
     }
else {
echo "Message could not be sent";
     }
?>