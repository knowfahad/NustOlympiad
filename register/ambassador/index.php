<?php
namespace Register;
require (__DIR__.'/../../bootstrap.php');
use App\OlMail;
use Respect\Validation\Validator as v;
$auth->onlyGuests();
$error = [];
$success = 0;
if($_SERVER['REQUEST_METHOD'] == "POST"){
	if(isset($_POST['cnic']) && strlen($_POST['cnic']))
		$cnic = test_input($_POST["cnic"]);
	else
		$error['cnic'] = "Please enter your CNIC number.";

	if(isset($_POST['first_name']) && strlen($_POST['first_name']))
		$first_name = test_input($_POST["first_name"]);
	else
		$error['first_name'] = "Please enter your First Name.";

	if(isset($_POST['last_name']) && strlen($_POST['last_name']))
		$last_name = test_input($_POST["last_name"]);
	else
		$error['last_name'] = "Please enter your Last Name.";

	if(isset($_POST['email']) && strlen($_POST['email']))
		$email = test_input($_POST["email"]);
	else
		$error['email'] = "Please enter your Email.";
	if(isset($_POST['institution']) && strlen($_POST['institution']))
		$institution = test_input($_POST["institution"]);
	else
		$error['institution'] = "Please enter your Institution Name.";
	if(isset($_POST['phone']) && strlen($_POST['phone']))
		$phone = test_input($_POST["phone"]);
	else
		$error['phone'] = "Please enter your Phone Number.";
	$phonevalidation = v::notEmpty()->numeric()->between(1000000000, 9999999999999);
	if(!$phonevalidation->validate($phone))
		$error['phone'] = "Please enter a valid phone number";
	$cnicvalidation = v::NotEmpty()->noWhitespace()
						->digit()->between(1000000000000, 9999999999999);
	if(!$cnicvalidation->validate($cnic))
		$error['cnic'] = "Please enter a valid CNIC number!";
	$emailvalidation = v::NotEmpty()->email();
	if(!$emailvalidation->validate($email))
		$error['email'] = "Please enter a valid email address";
	$ipaddress = \App\get_client_ip();
	$captcha = \App\send_post("https://www.google.com/recaptcha/api/siteverify", 
				[
				"secret" 	=> "6Ldgtg0UAAAAAHx4_kcm5G95hD8CCnEd_AcQeY6k",
				"response"	=> $_POST['g-recaptcha-response'],
				"remoteip"	=> $ipaddress
				]);
	if(!$captcha->success)
		$error['captcha'] = "Captcha is required!";


	if(!count($error)){
		//validate the inputs further
		if($stmt = $mpdo->prepare("select * from ambassador where CNIC = ?")){
			$stmt->execute([$cnic]);
			if(count($stmt->fetchAll())){
				$error['CNIC'] = "The CNIC is already registered!";
			}
		}

		if($stmt = $mpdo->prepare("select * from ambassador where email = ?")){
			$stmt->execute([$email]);
			if(count($stmt->fetchAll())){
				$error['CNIC'] = "The email is already in use!";
			}
		}

		if($stmt = $mpdo->prepare("select * from ambassador where phone_number	 = ?")){
			$stmt->execute([$phone]);
			if(count($stmt->fetchAll())){
				$error['CNIC'] = "The phone number is already in use";
			}
		}
	}

	if(!count($error)){
		$AmbassadorID = $first_name;
		$AmbassadorID .= bin2hex(mcrypt_create_iv(2, MCRYPT_DEV_URANDOM));
		// prepare and bind
		$stmt = $mpdo->prepare("INSERT INTO ambassador (AmbassadorID, CNIC, FirstName, LastName, phone_number, Email, Institution) VALUES (?, ?, ?, ?, ?,?, ?)");
		if($stmt->execute([$AmbassadorID, $cnic, $first_name, $last_name, $phone, $email, $institution])){
			$success = 1;
			$txtMessage = "Congratulations, \n \n You have been selected as an Ambassador for NUST Olympiad'17. \n These are your details as entered in the google form:\n \n Ambassador ID: $AmbassadorID \n Name: $first_name $last_name \n CNIC: $cnic \n Phone Number: $phone \n Institution:  $institution \n \n \n Please use the Ambassador ID above for future references. \n In case of any query or ambiguity, please contact er@nustolympiad.com.";
			$brmessage = nl2br($txtMessage);
			$htmlMessage = <<<htmlMessage
<html>
<body>
$brmessage
</body>
</html>
htmlMessage;
			$olmail = new OlMail(['name'=>$first_name.' '.$last_name,'email'=> $email], "Ambassador Info", $htmlMessage, $txtMessage );
			$olmail->send();
		}
		else
			$error['fatal'] = $stmt->error;
	}
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Ambassador Registration</title>
		
		<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body>
		<br>
		<div class="container">
		<?php if(count($error)): ?>
		<div class="alert">
			<ul class="list-group">
				<?php foreach($error as $field => $_error): ?>
				<li class="list-group-item list-group-item-danger"><?=$_error?></li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php endif ?>
		<?php if($success): ?>
		<!-- Success message -->
		<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>
		<?php else: ?>
		<form class="well form-horizontal" method="post" id="contact_form" >
			<fieldset>

			<!-- Form Name -->
			<legend>Ambassador Registration!</legend>

			<!-- Text input-->

			<div class="form-group">
			  <label class="col-md-4 control-label">First Name</label>  
			  <div class="col-md-4 inputGroupContainer">
			  <div class="input-group">
			  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			  <input  name="first_name" placeholder="First Name" class="form-control" 
			  value="<?=$_POST['first_name']?? ''?>"  type="text">
				</div>
			  </div>
			</div>

			<!-- Text input-->

			<div class="form-group">
			  <label class="col-md-4 control-label" >Last Name</label> 
				<div class="col-md-4 inputGroupContainer">
				<div class="input-group">
			  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
			  <input value="<?=$_POST['last_name']?? ''?>" name="last_name" placeholder="Last Name" class="form-control"  type="text">
				</div>
			  </div>
			</div>

			<!-- Email -->
				   <div class="form-group">
			  <label class="col-md-4 control-label">E-Mail</label>  
				<div class="col-md-4 inputGroupContainer">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
			  <input value="<?=$_POST['email']?? ''?>" name="email" placeholder="E-Mail Address e.g., nust@gmail.com" class="form-control"  type="text">
				</div>
			  </div>
			</div>


			<!-- Contact No -->

			<div class="form-group">
			  <label class="col-md-4 control-label">Contact No </label>  
				<div class="col-md-4 inputGroupContainer">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
			  <input value="<?=$_POST['phone']?? ''?>" name="phone" placeholder="0313XXXXXXX" class="form-control" type="text">
				</div>
			  </div>
			</div>

			<!-- CNIC -->

			<div class="form-group">
			  <label class="col-md-4 control-label">CNIC</label>  
				<div class="col-md-4 inputGroupContainer">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
			  <input value="<?=$_POST['cnic']?? ''?>"  name="cnic" placeholder="CNIC without dashes" class="form-control" type="numeric">
				</div>
			  </div>
			</div>

			<!-- Institution -->

			<div class="form-group">
			  <label class="col-md-4 control-label">Institution</label>  
				<div class="col-md-4 inputGroupContainer">
				<div class="input-group">
					<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
			  <input value="<?=$_POST['institution']?? ''?>" name="institution" placeholder="Institution Name e.g., NUST" class="form-control"  type="text">
				</div>
			  </div>
			</div> 

			<div class="form-group">
				<div class="g-recaptcha" data-sitekey="6Ldgtg0UAAAAAIGYMROWOzYRwq_qKR3dFWoRbqA9"></div>
			</div>

			<!-- Button -->
			<div class="form-group">
				<label class="col-md-4"></label>
			  <div class="col-md-4">
				 <input type="submit" name = "submit" class="btn btn-info" Value="Send">
			  </div>
			</div>

	</fieldset>
	</form>
	<?php endif ?>
		</div> <!-- /.container -->

		<!--- Scripts-->
		<script src="/js/jquery.js" type="text/javascript"></script>
		<script src="/js/app.js" type="text/javascript"></script>
		<!-- <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script> -->
		<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js" type="text/javascript"></script> -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="/js/bootstrap.min.js" type="text/javascript"></script>
	</body>
</html>