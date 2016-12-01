<?php 
namespace Register;
require_once (__DIR__ . '/../bootstrap.php');
use Respect\Validation\Validator as v;



/**
 * function that will validate the forms
 * and will prepare the inputs for database
 * will return two arrays, $errors and $data
 * @param  mysqli connection
 * @return arrays of errors and data
 */
function preprocess($conn){
 	$errors = [];
 	$data = [];

 	$data['username'] = strtolower( strip_tags( trim($_POST["username"]) ) );
 	$data['cnic'] = strip_tags( trim($_POST["cnic"]) );
 	$data['email'] = strtolower( strip_tags( trim($_POST["email"]) ) );
 	$data['pwd'] = $_POST["pwd"];
 	$data['repwd'] = strip_tags( trim($_POST["repwd"]) );  
 	$data['gender'] = "";
 	$data['phone'] = strip_tags( trim($_POST["mobile"]) );
 	$data['fname'] = strtolower( strip_tags( trim($_POST["fname"]) ) );
 	$data['lname'] = strtolower( strip_tags( trim($_POST["lname"]) ) );
 	$data['mobile'] = strip_tags( trim($_POST["mobile"]) );
 	$data['address'] = strtolower( strip_tags( trim($_POST["address"]) ) );
 	$data['isNustian'] = strip_tags( trim($_POST["isNustian"]) );
 	$data['ambassador'] = strip_tags( trim($_POST["ambassador"]) );  
 	$data['isAmbassador'] = false;

 	////basic validations
 	$usernamevalidation = v::NotEmpty()->NoWhitespace()->alnum()->length(6,20);
 	$cnicvalidation = v::NotEmpty()->noWhitespace()
 						->digit()->between(1000000000000, 9999999999999);
 	$emailvalidation = v::NotEmpty()->email();
 	$pwdvalidation = v::notEmpty()->length(8, null);
 	$phonevalidation = v::notEmpty()->numeric()->between(1000000000, 9999999999999);
 	$namevalidation = v::notEmpty()->alpha();
 	if(!$usernamevalidation->validate($data['username']))
 		$errors['username'] = "Please enter a valid username!";
 	if(!$cnicvalidation->validate($data['cnic']))
 		$errors['cnic'] = "Please enter a valid CNIC";
 	if(!$emailvalidation->validate($data['email']))
 		$errors['email'] = "Please enter a valid email address";
 	if(!$namevalidation->validate($data['fname']))
 		$errors['fname'] = "Please enter a valid first name";
 	if(!$namevalidation->validate($data['lname']))
 		$errors['lname'] = "Please enter a valid last name";
 	if(!$phonevalidation->validate($data['phone']))
 		$errors['phone'] = "Please enter a valid phone number";
 	if(!$phonevalidation->validate($data['mobile']))
 		$errors['mobile'] = "Please enter a valid mobile number";
 	if(!$pwdvalidation->validate($data['pwd']))
 		$errors['pwd'] = "Please enter a valid password";
 	if(!strlen($data['address']))
 		$errors['address'] = "Address is required!";
 	if($data['pwd'] != $data['repwd'])
 		$errors['repwd'] = "Repeat Password doesn't match!";

 	$length = 8;
 	$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

 	$acCode = '';
 	$max = mb_strlen($keyspace, '8bit') - 1;
 	for ($i = 0; $i < $length; ++$i) {
	 	$acCode .= $keyspace[random_int(0, $max)];
 	}
 	if($data['pwd'] != $data['repwd']){
	 	//return an error! 
	 	$errors['pwd'] = "Passwords dont match!";
 	}

 	/////advanced checking


 	//check if username already exists!
 	if ($stmt = $conn->prepare("SELECT * FROM useraccount WHERE Username =?")) {
	 	$stmt->bind_param("s", $data['username']);
	 	$stmt->execute();
	 	$result = $stmt->get_result();
	 	//if username already exists! 
	 	if(mysqli_num_rows($result) > 0) {
	 		
	 		//return error
	 		$errors['username'] = "username already exists!";
	 	}

	 	/* free results */
	 	$stmt->free_result();
	 	/* close statement */
	 	$stmt->close();
 	}
 	//check if nic exists

 	if ($stmt = $conn->prepare("SELECT * FROM participant WHERE CNIC =?")) {

	 	/* bind parameters for markers */
	 	$stmt->bind_param("s", $data['cnic']);

	 	/* execute query */
	 	$stmt->execute();
	 	$result = $stmt->get_result();

	 	//if cnic already exists! 

	 	if(mysqli_num_rows($result) > 0) {
	 		
	 		//return error
	 		$errors['cnic'] = "CNIC already exists!";
	 	}

	 	/* free results */
	 	$stmt->free_result();
	 	/* close statement */
	 	$stmt->close();
 	}

 	//check if email already exists
 	if ($stmt = $conn->prepare("SELECT * FROM useraccount WHERE Email =?")) {

	 	/* bind parameters for markers */
	 	$stmt->bind_param("s", $data['email']);

	 	/* execute query */
	 	$stmt->execute();
	 	$result = $stmt->get_result();

	 	//if email already exists! 

	 	if(mysqli_num_rows($result) > 0) {
	 		
	 		//return error
	 		$errors['email'] = "email already exists!";
	 	}

	 	/* free results */
	 	$stmt->free_result();
	 	/* close statement */
	 	$stmt->close();
 	}

 	if (isset($_POST['gender'])) {
	 	$data['gender'] = $_POST['gender'];
 	}
 	else{
	 	$errors['gender'] = "Select your gender please!";
 	}

 	if($data['isNustian'] == "n_yes"){
	 	$data['nustid'] = $_POST["nustid"];
 	}
 	else
 		$data['isNustian'] = false;

 	if($data['ambassador'] == "a_yes"){
	 	$data['ambassador_id'] = $_POST["ambassadorID"];
	 	$data['isAmbassador'] = true;
	 	//check whether the ambassador exists in database. Else return error!
	 	if ($stmt = $conn->prepare("SELECT * FROM Ambassador WHERE AmbassadorID =?")) {

	 		/* bind parameters for markers */
	 		$stmt->bind_param("s", $data['ambassador_id']);

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
	 			$errors['ambassadorID'] = "Ambassador id doesnot exist!";
	 		}
	 		
	 		/* free results */
	 		$stmt->free_result();
	 		/* close statement */
	 		$stmt->close();
	 	}
	 }
	else
		$data['isAmbassador'] = false;
 	return [$errors, $data];
}

/**
 * Generates Chalan, Saves the user to database and Add a new participant
 * @param  mysqli connection
 * @param  data
 * @return errors
 */
function persistUser($data, $conn){ //execution will only start if there are no errors
	$errors = [];
  
	//image processing part will go here


	//Populate challan table first!

	//create reg Challan and account Ac Code

    $nextid = $conn->query("select max(`ParticipantID`) as max from `participant`")
    		->fetch_object()
    		->max + 1;
    $regChallan = "RC";
    $regChallan .= $nextid;
	$regChallan .= ($data['isAmbassador']) ? '1' : '0';
	
    if($stmt = $conn->prepare("INSERT INTO challan (ChallanID, AmountPayable, DueDate, PaymentStatus) VALUES (?,?,?,?)")){
		$date= '20170101';
		$am = 1000;
		$s= 0;
		$stmt->bind_param("sisi", $regChallan,$am,$date, $s);
		
		$stmt->execute();
		
		$stmt->close();
	}
	else{
		$errors['Fatal'] =("\ninsert challan not executed!\n");
		exit();
	}


	//insert into participant
	
	if($data['isAmbassador'] == true){
		if($stmt = $conn->prepare("INSERT INTO participant (CNIC,FirstName,LastName,Gender,Address,PhoneNo, RegistrationChallanID,NUSTRegNo,AmbassadorID) VALUES (?,?,?,?,?,?,?,?,?)")){

		
		
		$stmt->bind_param("sssssssss", $data['cnic'], $data['fname'], $data['lname'], $data['gender'], $data['address'], $data['phone'], $regChallan,$data['nustid'], $data['ambassador_id']);
		
		$stmt->execute();
		
		echo $stmt->error;
		$stmt->close();
		}
		else{
			echo("\ninsert into participant not executed!\n");
		}
	
	}
	else{
		if($stmt = $conn->prepare(
			"INSERT INTO participant (CNIC,FirstName,LastName,Gender,Address,PhoneNo, RegistrationChallanID,NUSTRegNo) VALUES (?,?,?,?,?,?,?,?)")){

		
		
		$stmt->bind_param("ssssssss", $data['cnic'], $data['fname'], $data['lname'], $data['gender'], $data['address'], $data['phone'], $regChallan, $data['nustid']);
		
		$stmt->execute();
		
		$stmt->close();
		}
		else{
			$errors['fatal'] = ("insert participant not executed!");
			exit();
		}
		
	}
	// insert into account!
	
	if($stmt = $conn->prepare("INSERT INTO useraccount (username, ParticipantCNIC,Email,Password, AccountStatus, ActivationCode,ResetCode) VALUES (?,?,?,?,?,?,?)")){

		$rCode= 'Null';
		$status = 0;
		$pwdhash = password_hash($data['pwd'], PASSWORD_BCRYPT );
		$stmt->bind_param("ssssiss", $data['username'],$data['cnic'],$data['email'], $pwdhash, $status, $acCode, $rCode);
		
		$stmt->execute();
		$stmt->close();
	}

	return $errors;
}


