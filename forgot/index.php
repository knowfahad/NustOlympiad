<?php
require_once(__DIR__."/../bootstrap.php");
use Respect\Validation\Validator as v;
$auth->onlyGuests();
function sanitize($data){
    return htmlspecialchars(strip_tags($data));
}

$formsubmitted = $_SERVER['REQUEST_METHOD'] == 'POST';
$success = false;
if($formsubmitted){
    $errors = [];
	$email = sanitize($_POST['email'] ?? "");
	$emailvalidation = v::NotEmpty()->email();
	if(!$emailvalidation->validate($email)){
		$errors['email'] = "Please enter a valid email address.";
	}

	if(!count($errors)){
		$stmt = $mpdo->prepare("SELECT * FROM useraccount WHERE email = ?");
		$stmt->execute([$email]);
		$userdetails = $stmt->fetch(PDO::FETCH_OBJ);
		if(!$stmt->rowCount()){
			$errors['email'] = "This email doesn't belong to any account!";
		}
	}

	if(!count($errors)){
		$resetcode = bin2hex(mcrypt_create_iv(30, MCRYPT_DEV_URANDOM));
		$link = $_SERVER['SERVER_NAME']."/forgot/reset.php?token=".$resetcode;
        $stmt = $mpdo->prepare("update useraccount set ResetCode = ? where email = ?");
        $stmt->execute([$resetcode, $email]);
		$txtMessage = "Dear ".$userdetails->Username."/n You have requested to reset your Olympiad Password. Click on the link to reset the password /n";
		$htmlmessage = 
<<<htmlMessage
<!doctype html>
<html>
<body>
$txtMessage
<a href="$link">$link</a>
</body>
</html>
htmlMessage;
		$mail = new App\OlMail(["name"=>$userdetails->Username, "email"=>$email], "Reset Your Olympiad Password", $txtMessage.$link, $htmlmessage);
		$mail->send();
	}
    $success = true;

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
                        <?php if( $formsubmitted && count($errors) ): ?>
                            <div class="col-md-10 col-md-offset-1 col-xs-12">
                                <div class="container-fluid">
                        <div  id =  'errorShow' class = "row">
                        <!--append errors here! -->
                            <?php foreach($errors as $error): ?>
                            <div class="row"><?=$error?></div>
                            <?php endforeach ?>
                        </div>
                        </div></div>
                        <?php endif ?>
                        <?php if($success): ?>
                            <div class="col-md-10 col-md-offset-1 col-xs-12">
                                <div class="container-fluid">
                                    <div  id =  'errorShow' class = "row">
                                        <div class="alert alert-success">
                                            Link to reset password has been sent to your email address.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                        <div class="col-md-6 col-md-offset-3">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1 col-xs-12">
                                    <div class="container-fluid">
                                    <form class="form-horizontal" method="POST" id="log_form">
                                        <div class="h3">Reset password</div>
                                        <br>
                                    	<div class="form-group">
                                            <div class="">
                                            <input id="email" name="email" placeholder="Enter Your Email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Your Email'" required>
                                            </div>
                                        </div>                             
            							<div class = "row">
                                            <div class="form-group"> 
                                                <center>
                                                    <button type="submit" class="btn btn-default">Submit</button>
                                                </center>
                                            </div>
            							</div>
                                        <div class = "row">
                                                <center>
                                                    <a href="/login">Login</a>
                                                </center>
            							</div>
            							<br>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif ?>
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
