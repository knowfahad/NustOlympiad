<?php
namespace Register;
require_once "../bootstrap.php";
include_once '../OlAssets/dbconnect.php';
include_once 'random_compat-master/lib/random.php';
$formsubmitted = $_SERVER['REQUEST_METHOD'] == 'POST'; //saved it as have to use later as well
if ($formsubmitted){
	// var_dump($_POST);
	//validates data and store errors. returns sanitized data ready to be inserted into database
	list($errors, $data) = preprocess($conn);
	//continue registeration if there are no errors
	if(!count($errors)){
		//persistUser is function to save the data to the database
		$errors = persistUser($data, $conn);
		// if(!count($errors))
		// 	//it means that registration is successfull.
		// 	//now log them in and redirect to dashboard
		// 	//they will get message to verify email in dashboard
		// 	if($auth->login($data['username'], $data['pwd']))
		// 		\App\redirect("/dashboard");
	}	
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<!-- GOOGLE reCaptcha -->
	<script src='https://www.google.com/recaptcha/api.js'></script>

	<script type="text/javascript">
$(document).ready(function(){
			$('#student_nust').on('change',function()
			{
				if( $(this).val()==="n_yes"){
					$("#nust_hid").show()
				}
				else{
					$("#nust_hid").hide()
				}
			});
			$('#ambassador').on('change',function(){
				if( $(this).val()==="a_yes"){
					$("#amb_hid").show()
				}
				else{
					$("#amb_hid").hide()
				}
			});


			function checkForm(form)
			{
    /*if(form.username.value == "") {
      alert("Error: Username cannot be blank!");
      form.username.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.username.value)) {
      alert("Error: Username must contain only letters, numbers and underscores!");
      form.username.focus();
      return false;
  }*/

  if(form.pwd.value != "" && form.pwd.value == form.repwd.value) {
      /*if(form.pwd.value.length < 6) {
        alert("Error: Password must contain at least six characters!");
        form.pwd.focus();
        return false;
      }
      if(form.pwd.value == form.username.value) {
        alert("Error: Password must be different from Username!");
        form.pwd.focus();
        return false;
      }
      re = /[0-9]/;
      if(!re.test(form.pwd.value)) {
        alert("Error: password must contain at least one number (0-9)!");
        form.pwd.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.pwd.value)) {
        alert("Error: password must contain at least one lowercase letter (a-z)!");
        form.pwd.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.pwd.value)) {
        alert("Error: password must contain at least one uppercase letter (A-Z)!");
        form.pwd.focus();
        return false;
    }*/

} 
else 
{
	alert("Error: Password fields don't match.");
	form.pwd.focus();
	return false;
}

/*alert("You entered a valid password: " + form.pwd.value);*/
return true;
}
});
</script>
</head>
<body>
	<h1>Register An Account</h1>
	<?php if( $formsubmitted && count($errors) ): ?>
		<div class="alert-danger">
			<ul class="list-group">
			<?php foreach($errors as $field => $error): ?>
				<li class="list-group-item"><?=$error ?></li>
			<?php endforeach ?>
			</ul>
		</div>
	<?php endif ?>



	<div class="alert-danger"></div>
	<form class="form-horizontal"  method = "POST" id="reg_form">
		<div class="form-group">
			<label class="control-label col-sm-2" for="username">Username:</label>
			<div class="col-sm-4">
				<input type="text" value="<?=$_POST['username']??''?>" class="form-control" id="username" name = "username" placeholder="Enter username">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="pwd">Password:</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" id="pwd" name = "pwd" placeholder="Enter password">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="repwd">Repeat password:</label>
			<div class="col-sm-4">
				<input type="password" class="form-control" id="repwd" name = "repwd" placeholder="re-enter password">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="name">Gender:</label>
			<div class="col-sm-4">
				<label class="radio-inline">
					<input type="radio" name="gender" value = "M">Male
				</label>
				<label class="radio-inline">
					<input type="radio" name="gender" value = "F">Female
				</label>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="fname">First Name:</label>
			<div class="col-sm-4">
				<input type="text" value="<?=$_POST['fname']??''?>" class="form-control" id="fname"  name = "fname" placeholder="Enter fname">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="lname">Last Name:</label>
			<div class="col-sm-4">
				<input type="text" value="<?=$_POST['lname']??''?>" class="form-control" id="lname" name = "lname" placeholder="Enter lname">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="cnic">CNIC:</label>
			<div class="col-sm-4">
				<input type="number" value="<?=$_POST['cnic']??''?>" class="form-control" id="cnic" name = "cnic" placeholder="Enter cnic">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="mobile">Mobile Number:</label>
			<div class="col-sm-4">
				<input type="number" value="<?=$_POST['mobile']??''?>" class="form-control" id="mobile" name = "mobile" placeholder="Enter mobile number">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="email">Email ID:</label>
			<div class="col-sm-4">
				<input type="email" value="<?=$_POST['email']??''?>" class="form-control" id="email" name = "email" placeholder="Enter email">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="pwd">Address:</label>
			<div class="col-sm-4"> 
				<input type="text" value="<?=$_POST['address']??''?>" class="form-control" id="address"  name = "address" placeholder="Enter address">
			</div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" >Are you a nust student?</label>
			<select class="selectpicker" name = "isNustian" id="student_nust">
				<option value="n_no">No</option>
				<option value="n_yes">Yes</option>

			</select>
		</div>
		<div class="form-group" id="nust_hid" style="display:none;">
			<label class="control-label col-sm-2" for="nust_id">Nust ID:</label>
			<div class="col-sm-4"> 
				<input type="text" class="form-control" id="nust_id" name = "nustid" placeholder="Enter id">
			</div>
		</div>
		<br>

		<div class="form-group">
			<label class="control-label col-sm-2" >Are you an ambassador?</label>
			<select class="selectpicker" name = "ambassador" id="ambassador">
				<option value="a_no">No</option>
				<option value="a_yes">Yes</option>
			</select>
		</div>
		<div class="form-group" id="amb_hid" style="display:none;">
			<label class="control-label col-sm-2" for="amb_id">Ambassador ID:</label>
			<div class="col-sm-4"> 
				<input type="text" class="form-control" id="amb_id" name = "ambassadorid" placeholder="Enter id">
			</div>
		</div>
		<br>

		<div class="form-group">
			<div class="g-recaptcha" data-sitekey="6Ldgtg0UAAAAAIGYMROWOzYRwq_qKR3dFWoRbqA9"></div>
		</div>
		<div class="form-group">
			<label class="control-label col-sm-2" for="pic">Upload a pic:</label>
			<input type="file" name="pic" accept="image/*">
			
		</div>
		<div class="form-inline">
			<div class="form-group"> 
				<div class="col-sm-offset-2 col-sm-4">
					<button type="submit" class="btn btn-default">Submit</button>
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-offset-4 col-sm-4">
					<button type="button" class="btn btn-default">Reset</button>
				</div>
			</div>
			<div class="form-group"> 
				<div class="col-sm-offset-5 col-sm-4">
					<button type="button" name="submit" class="btn btn-default">Cancel</button>
				</div>
			</div>
		</div>
	</form>
</body>




</html>