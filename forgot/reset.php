<?php 
require_once(__DIR__."/../bootstrap.php");
use Respect\Validation\Validator as v;

//three posibilities: 
//1- link is invalid - token from the get request
//2- link is valid: show email and password form - token from the get request

//check if the link is valid
$token = ($_GET['token']) ?? "";
$invalid = false;
$errors = [];

if(strlen(trim($token))){
	$stmt = $mpdo->prepare("select * from useraccount where ResetCode = ?");
	$stmt->execute([$token]);
	if(!$stmt->rowCount()){
		$invalid = true;
	}
}
else{
	$invalid = true;
}
//if the link is valid and the email and password is provided
if(!$invalid && isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['repwd']) ){
	$email = $_POST['email'];
	$pwd = $_POST['pwd'];
	$repwd = $_POST['repwd'];
	//now check if the data provided is valid
	$pwdvalidation = v::notEmpty()->length(8, null);
	$emailvalidation = v::NotEmpty()->email()->length(3,90);
	if(!$emailvalidation->validate($email))
		$errors[] = "Please enter a valid email address.";
	if(!$pwdvalidation->validate($pwd))
		$errors[] = "Password should be atleast 8 characters long.";
	if($pwd != $repwd)
		$errors[] = "Password and repeat password do not match.";
	//if the data is valid
	if(!count($errors)){
		//check if the the link actually belongs the the user.
		$stmt = $mpdo->prepare("select * from useraccount where Email = ? and ResetCode = ?");
		$stmt->execute([$email, $token]);
		if($stmt->rowCount()){
			$stmt = $mpdo->prepare("update useraccount set Password = ?, ResetCode = NULL where ResetCode = ? && Email = ?");
			$stmt->execute([password_hash($pwd, PASSWORD_BCRYPT ), $token, $email]);
			if($stmt->rowCount()){
				\App\redirect("/login");
			}
			else
				$errors[] = "Something went wrong!";
		}
		else{
			$errors[] = "This link is not valid for your account.";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset | NUST Olympiad '17</title>
    <link rel="stylesheet" type="text/css" href="../css/timeline.css">
    
    <link rel="stylesheet" href="../css/themify-icons.css">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel='stylesheet' href='../css/perfect-scrollbar.min.css' />
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/buttons.css" />
    <link rel="stylesheet" href="../css/animate.css" />
    <link rel="stylesheet" href="../css/tooltip.css" />
    
    <link rel="stylesheet" href="../css/demo3.css" />
    
    <script src='https://www.google.com/recaptcha/api.js'></script>

<link rel="stylesheet" href="../css/style2.css" />
    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Login</title>
   
    <!--<script type="text/javascript" async="" src="Register_files/recaptcha__en.js"></script><script src="Register_files/jquery.js"></script> -->
	
    <!-- <script src="https://maxdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    
	<!--<script src="Register_files/api.js"></script> -->
	
    <script type="text/javascript" src="../js/jquery.min.js"></script>
<style>
a{
color:white;
}
a:hover,a:focus{
color:white;
}
input{
	color:white;
	
}
label{
font-weight:normal;

}

.col-centered{
    float: none;
    margin: 0 auto;
}
</style>

</head>

<body id="id-body" >
    <div class="td-preloading">
        <span class="fa fa-spinner fa-spin"></span>
    </div>
    
    <div class="td-container">
        <!--<div class="row">
        <div class="col-md-4 col-md-offset-4 col-xs-8 col-xs-offset-2  col-sm-4 col-sm-offset-4">
            <img src="../img/cube.png" alt="" style="margin-bottom:0;">
        </div>
    </div>-->
        <div class="td-sheets-container td-hide td-sheet-active-1">
            <div class="row">
        
            </div>
            <div id="scrollbar-container" class="td-sheet active">
                <div class="container-fluid">
				
				<div class = "row">
					<div class = "col-md-3 col-centered col-sm-3" >
					
					
					<a href="../index.html">
						<img src="../img/logo.png" class="img-responsive" alt="LOGO"/>
					</a>	
					
					</div>
				</div>  
				
                    <div class="row homepage" >
                        <?php if(count($errors) ): ?>
                            <div class="col-md-10 col-md-offset-1 col-xs-12">
                                <div class="container-fluid">
                        <div  id =  'errorShow' class = "row">
                        <!--append errors here! -->
                            <?php foreach($errors as $field => $error): ?>
                            <div class="alert alert-danger"><?=$error?></div>
                            <?php endforeach ?>
                        </div>
                        </div></div>
                        <?php endif ?>
                        <div class="col-md-6 col-md-offset-3">
                            <div class="row">
                                 <div class="col-md-10 col-md-offset-1 col-xs-12">
                                     <div class="container-fluid">
										<?php if(!$invalid): ?>
			                            <form class="form-horizontal" method="POST" id="log_form">
											<div class="h3">Reset password</div>
				                            <br>
											<div class="form-group">
				                                <div class="">
				                                    <input id="email" name="email" placeholder="Enter Your Email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Your Email'" required>
				                                </div>
				                            </div>
											<div class="form-group">
					                            <div class="">
					                                <input id="pwd" name="pwd" placeholder="New Password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'New Password'" required>
					                            </div>
					                        </div>
				    						<div class="form-group">
				                                <div class="">
				                                    <input id="repwd" name="repwd" placeholder="Confirm Password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'" required>
				                                </div>
				                            </div>
											<div class = "row">
				                                <div class="form-group"> 
				                                    <center>
				                                        <button type="submit" class="btn btn-default">Submit</button>
				                                    </center>
				                                </div>
											</div>
											</form>
			                            <?php else: ?>
			                            <h3>Invalid Link!</h3>
			                            <?php endif ?>
	        							<br>
			                            <div class = "row">
			                                    <center>
			                                        <a href="../login/login.html">Login</a>
			                                    </center>
										</div>
										<br>
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="../js/jquery.min.js"></script>
            <script src="../js/responsive.js"></script>
            <script src="../js/perfect-scrollbar.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/jquery.visible.min.js"></script>
            <script src="../js/scriptdemo3.js"></script>
            <script src="../js/classie.js"></script>
            <script src="../js/detectanimation.js"></script>
            <script src="../js/modernizr.custom.js"></script>
           
            <script type="text/javascript" src="../js/timeline.js"></script>
           
</body>

</html>
