<?php 

use App\OlMail;
require_once(__DIR__."/../../bootstrap.php");
$auth->onlyLoggedIn();
$auth->onlyUnVerified();

$user = $auth->User()->toArray();
$formsubmitted = $_SERVER['REQUEST_METHOD'] == 'POST'; //saved it as have to use later as well
if($formsubmitted){
 	$ipaddress = \App\get_client_ip();
 	$captcha = \App\send_post("https://www.google.com/recaptcha/api/siteverify", 
				[
				"secret" 	=> "6Ldgtg0UAAAAAHx4_kcm5G95hD8CCnEd_AcQeY6k",
				"response"	=> $_POST['g-recaptcha-response'],
				"remoteip"	=> $ipaddress
				]);
 	if(!$captcha->success)
 		$error = "Captcha is required!";

	if(!isset($error)){
		$heading = "Welcome to NUST OLYMPIAD!";
		$link = $_SERVER['SERVER_NAME']."/register/verify/?username=".$user['Username']."&activationcode=".$user['Activationcode'];
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
			
		$mail = new OlMail(['name'=>$user['Username'], 'email'=>$user['Email']], 'Verify your account | NUST OLYMPIAD 17', $htmlmessage, $txtmessage );
		$mail->send();
		$message = "The email has been sent successfully. Check the spam or junk folder, or contact us for assistance.";
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset | NUST Olympiad '17</title>
    <link rel="stylesheet" type="text/css" href="/css/timeline.css">
    
    <link rel="stylesheet" href="/css/themify-icons.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel='stylesheet' href='/css/perfect-scrollbar.min.css' />
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/css/buttons.css" />
    <link rel="stylesheet" href="/css/animate.css" />
    <link rel="stylesheet" href="/css/tooltip.css" />
    
    <link rel="stylesheet" href="/css/demo3.css" />
    
    <script src='https://www.google.com/recaptcha/api.js'></script>

<link rel="stylesheet" href="/css/style2.css" />
    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Login</title>
   
    <!--<script type="text/javascript" async="" src="Register_files/recaptcha__en.js"></script><script src="Register_files/jquery.js"></script> -->
	
    <!-- <script src="https://maxdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    
	<!--<script src="Register_files/api.js"></script> -->
	
    <script type="text/javascript" src="/js/jquery.min.js"></script>

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
            <img src="/img/cube.png" alt="" style="margin-bottom:0;">
        </div>
    </div>-->
        <div class="td-sheets-container td-hide td-sheet-active-1">
            <div class="row">
        
            </div>
            <div id="scrollbar-container" class="td-sheet active">
                <div class="container-fluid">
				
				<div class = "row">
					<div class = "col-md-3 col-centered col-sm-3" >
						<a href="/index.html">
							<img src="/img/logo.png" class="img-responsive" alt="LOGO"/>
						</a>	
					</div>
				</div>  
				
                    <div class="row homepage" >
	                    <div class="col-md-6 col-md-offset-3">
	                        <div class = "row">
                            	<div class="row">
	            					<?php if( $formsubmitted && isset($error) ): ?>
	                                    <div class="col-md-10 col-md-offset-1 col-xs-12">
	                                        <div class="container-fluid">
	                                <div  id =  'errorShow' class = "alert alert-danger">
	                                <!--append errors here! -->
	                                    <div class="row">&nbsp;<?=$error?></div>
	                                </div>
	                                </div></div>
	                                <?php endif ?>

                					<?php if( $formsubmitted && isset($message) ): ?>
                                        <div class="col-md-10 col-md-offset-1 col-xs-12">
                                            <div class="container-fluid">
                                    <div  id =  'errorShow' class = "alert alert-success">
                                    <!--append errors here! -->
                                        <div class="row">&nbsp;<?=$message?></div>
                                    </div>
                                    </div></div>
                                    <?php endif ?>
                            	</div>
                            	<?php if( !isset($message) ): ?>
	                        	<form method="POST">
	                        		<div class="form-group">
	                        		    <div class="g-recaptcha" data-sitekey="6Ldgtg0UAAAAAIGYMROWOzYRwq_qKR3dFWoRbqA9"></div>
	                        		</div>
	                        		<button class="btn btn-default" type="submit">Resend Email!</button>
	                        	</form>
		                        <?php endif ?>
							</div>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <script src="/js/jquery.min.js"></script>
            <script src="/js/responsive.js"></script>
            <script src="/js/perfect-scrollbar.min.js"></script>
            <script src="/js/bootstrap.min.js"></script>
            <script src="/js/jquery.visible.min.js"></script>
            <script src="/js/scriptdemo3.js"></script>
            <script src="/js/classie.js"></script>
            <script src="/js/detectanimation.js"></script>
            <script src="/js/modernizr.custom.js"></script>
           
            <script type="text/javascript" src="/js/timeline.js"></script>
           
</body>

</html>