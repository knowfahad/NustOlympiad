<?php 
namespace Register;
require_once (__DIR__ . '/../bootstrap.php');
use App\OlMail;
use Respect\Validation\Validator as v;



/**
 * function that will validate the forms
 * and will prepare the inputs for database
 * will return two arrays, $errors and $data
 * @param  mysqli connection
 * @return arrays of errors and data
 */
function preprocess($mpdo){
 	$errors = [];
 	$data = [];

 	$data['username'] = strtolower( strip_tags( trim($_POST["username"]) ) );
 	$data['cnic'] = strip_tags( trim($_POST["cnic"]) );
 	$data['email'] = strtolower( strip_tags( trim($_POST["email"]) ) );
 	$data['pwd'] = $_POST["pwd"];
 	$data['repwd'] = $_POST["repwd"];  
 	$data['gender'] = "";
 	$data['phone'] = strip_tags( trim($_POST["mobile"]) );
 	$data['fname'] = strtolower( strip_tags( trim($_POST["fname"]) ) );
 	$data['lname'] = strtolower( strip_tags( trim($_POST["lname"]) ) );
 	$data['mobile'] = strip_tags( trim($_POST["mobile"]) );
 	$data['address'] = strtolower( strip_tags( trim($_POST["address"]) ) );
 	$data['isNustian'] = strip_tags( trim($_POST["isNustian"]) );
 	$data['ambassador'] = strip_tags( trim($_POST["ambassador"]) );  
 	$data['isAmbassador'] = false;
 	$data['ambassadorid'] = strip_tags( trim($_POST["ambassador"] ?? ""));
 	$data['institute'] = strip_tags( trim($_POST["institute"] ?? ""));

 	////basic validations
 	$usernamevalidation = v::NotEmpty()->NoWhitespace()->alnum()->length(3,20);
 	$cnicvalidation = v::NotEmpty()->noWhitespace()
 						->digit()->between(1000000000000, 9999999999999);
 	$emailvalidation = v::NotEmpty()->email();
 	$pwdvalidation = v::notEmpty()->length(8, null);
 	$phonevalidation = v::notEmpty()->numeric()->between(3000000000, 3499999999);
 	$namevalidation = v::notEmpty()->alpha();
 	$nustidvalidation = v::notEmpty()->numeric()->numeric->between(100000, 99999999);
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
 		$errors['pwd'] = "Password must be minimum 8 characters";
 	if(!strlen($data['address']))
 		$errors['address'] = "Address is required!";
 	if($data['pwd'] != $data['repwd'])
 		$errors['repwd'] = "Repeat Password doesn't match!";
 	if(!$namevalidation->validate($data['institute']))
 		$errors['institute'] = "Please enter the valid name of your institute.";
 	$ipaddress = \App\get_client_ip();
 	$captcha = \App\send_post("https://www.google.com/recaptcha/api/siteverify", 
				[
				"secret" 	=> "6Ldgtg0UAAAAAHx4_kcm5G95hD8CCnEd_AcQeY6k",
				"response"	=> $_POST['g-recaptcha-response'],
				"remoteip"	=> $ipaddress
				]);
 	if(!$captcha->success)
 		$errors['captcha'] = "Captcha is required!";

 	/////advanced checking


 	//check if username already exists!
 	if ($stmt = $mpdo->prepare("SELECT * FROM useraccount WHERE Username =?")) {
	 	$stmt->execute([$data['username']]);
	 	if($stmt->rowCount() > 0) {
	 		$errors['username'] = "username already exists!";
	 	}
 	}

 	//check if nic exists
 	if ($stmt = $mpdo->prepare("SELECT * FROM participant WHERE CNIC =?")) {
	 	$stmt->execute([$data['cnic']]);
	 	if($stmt->rowCount()  > 0) {
	 		$errors['cnic'] = "CNIC already exists!";
	 	}
 	}

 	//check if email already exists
 	if ($stmt = $mpdo->prepare("SELECT * FROM useraccount WHERE Email =?")) {
	 	$stmt->execute([$data['email']]);
	 	if($stmt->rowCount()  > 0) {
	 		$errors['email'] = "email already exists!";
	 	}
 	}

 	if (isset($_POST['gender'])) {
	 	$data['gender'] = $_POST['gender'];
 	}
 	else{
	 	$errors['gender'] = "Select your gender please!";
 	}

 	if($data['isNustian'] == "n_yes"){
	 	$data['nustid'] = strip_tags(trim($_POST["nustid"]));
	 	if(!$nustidvalidation->validate($data['nustid'])){
	 		$errors['nustid'] = "Please enter a valid CMS ID";
	 	}

 	}
 	else
 		$data['isNustian'] = false;

 	if($data['ambassador'] == "a_yes"){
	 	$data['ambassador_id'] = $_POST["ambassadorid"];
	 	$data['isAmbassador'] = true;


	 	//check whether the ambassador exists in database. Else return error!
		///check if the CNIC provided matches the CNIC of the ambassador id provided
		if($stmt = $mpdo->prepare("SELECT * from ambassador where AmbassadorID = ? AND CNIC = ?")){
			$stmt->execute([$data['ambassador_id'], $data['cnic']]);
			if($stmt->rowCount() == 0){
				$errors["ambassadorid"] = 'Wrong ambassador credidentials!';
			}
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
function persistUser($data, $mpdo){ //execution will only start if there are no errors
	$errors = [];

	//image processing part will go here


	//Populate challan table first!

	//create reg Challan and account Ac Code

    $nextid = $mpdo->query("select max(`ParticipantID`) as max from `participant`")
    		->fetchObject()
    		->max + 1;
    $regChallan = "RC";
    $regChallan .= $nextid;
	$regChallan .= ($data['isAmbassador']) ? '1' : '0';
	
    if($stmt = $mpdo->prepare("INSERT INTO challan (ChallanID, AmountPayable, DueDate, PaymentStatus) VALUES (?,?,?,?)")){
		$date= '20170101';
		$am = 1000;
		$s= 0;
		$stmt->execute([$regChallan,$am,$date, $s]);
	}
	else{
		$errors['Fatal'] =("\ninsert challan not executed!\n");
		exit();
	}


		//insert into participant
	try{
		if($data['isAmbassador'] == true){
			$stmt = $mpdo->prepare("INSERT INTO participant (institution, CNIC,FirstName,LastName,Gender,Address,PhoneNo, RegistrationChallanID, NUSTRegNo, AmbassadorID) VALUES (?,?,?,?,?,?,?,?,?, ?)");
			$stmt->execute([$data['institute'], $data['cnic'], $data['fname'], $data['lname'], $data['gender'], $data['address'], $data['phone'], $regChallan, $data['nustid'], $data['ambassador_id']]);
			if($stmt->rowCount() == 0){
				$errors['fatal'] = "Some error occured!";
			}
		}
		else{
			$stmt = $mpdo->prepare("INSERT INTO participant (institution, CNIC,FirstName,LastName,Gender,Address,PhoneNo, RegistrationChallanID, NUSTRegNo) VALUES (?,?,?,?,?,?,?,?,?)");
			$stmt->execute([ $data['institute'], $data['cnic'], $data['fname'], $data['lname'], $data['gender'], $data['address'], $data['phone'], $regChallan, $data['nustid']]);
			if($stmt->rowCount() == 0){
				$errors['fatal'] = "Some error occured!";
			}
		}
	}
	catch(Exception $e){
	}

		
		// insert into account!
		
	try{
		$stmt = $mpdo->prepare("INSERT INTO useraccount (username, ParticipantCNIC,Email,Password, AccountStatus, ActivationCode,ResetCode) VALUES (?,?,?,?,?,?,?)");
				$rCode= 'Null';
				$status = 0;
				$acCode = bin2hex(mcrypt_create_iv(30, MCRYPT_DEV_URANDOM));
				$pwdhash = password_hash($data['pwd'], PASSWORD_BCRYPT );
				$stmt->execute([$data['username'],$data['cnic'],$data['email'], $pwdhash, $status, $acCode, $rCode]);
	}
	catch(Exception $e){
		var_dump($e);
	}
// sending mail

	$heading = "Welcome to NUST OLYMPIAD!";
	$link = $_SERVER['SERVER_NAME']."/register/verify/?Username=".$data['username']."&ActivationCode=$acCode";

$htmlmessage = 
<<<emailmessage
<html>
<body>
<h2>$heading</h2>
<p>Plese click on this link to verify your email:</p>
<a href="$link">$link</a>
<hr />
</body>
</html>
emailmessage;

$txtmessage = "$heading /n Please open this link to verify your email: $link";
	
	$mail = new OlMail(['name'=>$data['username'], 'email'=>$data['email']], 'Verify your account | NUST OLYMPIAD 17', $htmlmessage, $txtmessage );
	$mail->send();

	return $errors;
}


