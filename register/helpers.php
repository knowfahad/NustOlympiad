<?php 
namespace Register;
require_once (__DIR__ . '/../bootstrap.php');
use App\OlMail;
use Respect\Validation\Validator as v;

function sanitize($data){
    return htmlspecialchars(strip_tags($data));
}

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

 	$data['username'] = strtolower( sanitize( trim($_POST["username"]) ) );
 	$data['cnic'] = sanitize( trim($_POST["cnic"]) );
 	$data['email'] = strtolower( sanitize( trim($_POST["email"]) ) );
 	$data['pwd'] = $_POST["pwd"];
 	$data['repwd'] = $_POST["repwd"];  
 	$data['gender'] = "";
 	$data['phone'] = sanitize( trim($_POST["mobile"]) );
 	$data['fname'] = strtolower( sanitize( trim($_POST["fname"]) ) );
 	$data['lname'] = strtolower( sanitize( trim($_POST["lname"]) ) );
 	$data['mobile'] = sanitize( trim($_POST["mobile"]) );
 	$data['address'] = strtolower( sanitize( trim($_POST["address"]) ) );
 	$data['isNustian'] = sanitize( trim($_POST["isNustian"]) );
 	$data['ambassador'] = sanitize( trim($_POST["ambassador"]) );  
 	$data['isAmbassador'] = false;
 	$data['ambassadorid'] = sanitize( trim($_POST["ambassador"] ?? ""));
 	$data['institute'] = sanitize( trim($_POST["institute"] ?? ""));

 	////basic validations
 	$allowed = ['jpg', 'jpeg', 'JPG', 'JPEG'];
 	$max_size = 2;
	$ipaddress = \App\get_client_ip();
	$captcha = \App\send_post("https://www.google.com/recaptcha/api/siteverify", 
			[
			"secret" 	=> "6Ldgtg0UAAAAAHx4_kcm5G95hD8CCnEd_AcQeY6k",
			"response"	=> $_POST['g-recaptcha-response'],
			"remoteip"	=> $ipaddress
			]);
	if(!$captcha->success)
		$errors['captcha'] = "Captcha is required!";	
 	if(isset($_FILES['img'])){
		$data['img'] = $_FILES['img'];
		$info = pathinfo($data['img']['name']);
		if(!isset($info['extension'])){
			$errors["file"] = "Please upload an image!";
		}
		else{
			$ext = $info['extension'];
			$size = $data['img']['size']/1048576;
			
			if($size>$max_size){
				$errors["size"] = "The photos must be less than ".$max_size." MBs.";	
			}
			if(!in_array($ext,$allowed)){
				$errors["ext"] = "The photo must be in JPEG format.";
			}
		}
	}
	else{
	 	$errors["file"] = "Please upload your photo";
	}
	if(count($errors))
		return [$errors, $data];
 	
 	$usernamevalidation = v::NotEmpty()->NoWhitespace()->alnum()->length(3,15);
 	$cnicvalidation = v::NotEmpty()->noWhitespace()
 						->digit()->between(1000000000000, 9999999999999);
 	$emailvalidation = v::NotEmpty()->email()->length(3,90);
 	$pwdvalidation = v::notEmpty()->length(8, null);
 	$phonevalidation = v::notEmpty()->digit()->between(3000000000, 3499999999);
 	$namevalidation = v::notEmpty()->alpha()->length(1,50);
 	$nustidvalidation = v::notEmpty()->digit()->between(10000, 99999999);
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
 	

 	/////advanced checking

 	if(count($errors)){
 		return [$errors, $data];
 	}


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
	 	$data['nustid'] = sanitize(trim($_POST["nustid"]));
	 	if(!$nustidvalidation->validate($data['nustid'])){
	 		$errors['nustid'] = "Please enter a valid CMS ID";
	 	}
 	}
 	else{
 		$data['nustid'] = null;
 	}

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

	$errors = uploadimg($data['img'], "photos", $data['cnic'], 2);
	if(count($errors))
		return $errors;
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
		if(strlen($data['nustid']))
			$s= 1;
		else
			$s = 0;
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
	$link = "http://".$_SERVER['SERVER_NAME']."/register/verify/?username=".$data['username']."&activationcode=$acCode";

$htmlmessage = 
<<<emailmessage
<html>
<body>
<p>
Dear Participant,<br>
Thank you for registering with NUST Olympiad '17.
</p>

<p>
To activate your account, please visit the link below: <br>
<a href="$link">$link</a>
<br>
<i>If the above link does not work, please copy and paste it into your browser</i>
</p>
<p>
We look forward to see your exuberant participation in the biggest Olympiad of the year!
</p>
<hr>
<p>
This message is generated automatically, please do not reply to this email. If you have any questions or suggestions, please send an email to <a href="mailto:er@nustolympiad.com>er@nustolympiad.com</a>
</p>

Regards,
NUST Olympiad team
<hr />
</body>
</html>
emailmessage;

$txtmessage = "Dear Participant, \n

Thank you for registering with NUST Olympiad '17.\n

To activate your account, please visit the link below: \n

$link\n

(If the above link does not work, please copy and paste it into your browser) \n

We look forward to see your exuberant participation in the biggest Olympiad of the year!\n

This message is generated automatically, please do not reply to this email. If you have any questions or suggestions, please send an email to er@nustolympiad.com\n

Regards,
NUST Olympiad team";
	
	$mail = new OlMail(['name'=>$data['username'], 'email'=>$data['email']], 'Verify your account | NUST Olympiad 17', $htmlmessage, $txtmessage );
	$mail->send();

	return $errors;
}

function resize_image($file, $newwidth, $newheight) {
    list($width, $height) = getimagesize($file);
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor( $newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0,  $newwidth, $newheight, $width, $height);
    imagejpeg($dst, $file, 100);
}

function uploadimg($img, $dir, $name, $max_size){
	$errors = [];
	$path = "";
	$allowed = ['jpg', 'jpeg'];
	try{
		$info = pathinfo($img['name']);
		if(!isset($info['extension'])){
			$errors[] = "Please upload an image!";
			return $errors;
		}
		$ext = $info['extension'];
		$size=$img['size']/1048576;
		
		if($size>$max_size){
			$errors["size"] = "The photos must be less than ".$max_size.".";	
		}
		if(!in_array($ext,$allowed)){
			$errors["ext"] = "The photo must be in JPEG format.";
		}
		if(!count($errors)){
			$newname = $name.".jpg"; 
			$target = __DIR__."/../".$dir."/".$newname;

			if (!move_uploaded_file($img['tmp_name'], $target))
				$errors['An unknown error occured uploading your photo.'];
			else
				resize_image($target, 200, 200);
		}
	}
	catch(Exception $e){
		$errors[] = "An error occured with uploading image!";
	}
	return $errors;
}