<?php include("connect.php"); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Ambassador Registration</title>
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">

		<style>
			#success_message{ display: none;}
		</style>
	</head>
	<body>
		<br>
		<div class="container">

			<form class="well form-horizontal" action="ambassador.php" method="post" id="contact_form" >
				<fieldset>

				<!-- Form Name -->
				<legend>Ambassador Registration!</legend>

				<!-- Text input-->

				<div class="form-group">
				  <label class="col-md-4 control-label">First Name</label>  
				  <div class="col-md-4 inputGroupContainer">
				  <div class="input-group">
				  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				  <input  name="first_name" placeholder="First Name" class="form-control"  type="text">
					</div>
				  </div>
				</div>

				<!-- Text input-->

				<div class="form-group">
				  <label class="col-md-4 control-label" >Last Name</label> 
					<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
				  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
				  <input name="last_name" placeholder="Last Name" class="form-control"  type="text">
					</div>
				  </div>
				</div>

				<!-- Email -->
					   <div class="form-group">
				  <label class="col-md-4 control-label">E-Mail</label>  
					<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
				  <input name="email" placeholder="E-Mail Address e.g., nust@gmail.com" class="form-control"  type="text">
					</div>
				  </div>
				</div>


				<!-- Contact No -->

				<div class="form-group">
				  <label class="col-md-4 control-label">Contact No </label>  
					<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
				  <input name="phone" placeholder="0313-XXXXXXX" class="form-control" type="text">
					</div>
				  </div>
				</div>

				<!-- CNIC -->

				<div class="form-group">
				  <label class="col-md-4 control-label">CNIC</label>  
					<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  <input  name="cnic" placeholder="CNIC e.g., 7140X-XXXXXXX-X" class="form-control" type="text">
					</div>
				  </div>
				</div>

				<!-- Institution -->

				<div class="form-group">
				  <label class="col-md-4 control-label">Institution</label>  
					<div class="col-md-4 inputGroupContainer">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
				  <input name="institution" placeholder="Institution Name e.g., NUST" class="form-control"  type="text">
					</div>
				  </div>
				</div> 
					
				<!-- Success message -->
				<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Thanks for contacting us, we will get back to you shortly.</div>

				<!-- Button -->
				<div class="form-group">
					<label class="col-md-4"></label>
				  <div class="col-md-4">
					 <input type="submit" name = "submit" class="btn btn-info" Value="Send">
				  </div>
				</div>

		</fieldset>
		</form>
		</div> <!-- /.container -->

		<!----------------------- Scripts----------------->
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="js/app.js" type="text/javascript"></script>
		<script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js" type="text/javascript"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

		
		

	</body>
</html>
<?php 
	if(isset($_POST["submit"])){
	
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO ambassador (AmbassadorID, CNIC, FirstName, LastName, Email,Institution) VALUES (?, ?, ?, ?, ?,?)");
	$stmt->bind_param("ssssss", $AmbassadorID, $CNIC, $FirstName, $LastName, $Email, $Institution);

	$AmbassadorID = "12"; 
	$CNIC = test_input($_POST["cnic"]);
 
    $FirstName = test_input($_POST["first_name"]);
	$LastName = test_input($_POST["last_name"]);
    $Email = test_input($_POST["email"]);
  //  $phone = test_input($_POST["phone"]);
    $Institution = test_input($_POST["institution"]);
    if($stmt->execute())
	{	
		echo "inserted";
	}
		$stmt->close();
$conn->close();
		
	} 
		
	function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>