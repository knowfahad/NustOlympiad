<?php 
require_once('../bootstrap.php');

if($auth->loggedIn()){
    \App\redirect("/dashboard");
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $continue = 0;
    if(isset($_SESSION['failed']) && $_SESSION['failed'] > 3){
        $ipaddress = \App\get_client_ip();
        $captcha = \App\send_post("https://www.google.com/recaptcha/api/siteverify", 
                [
                "secret"    => "6Ldgtg0UAAAAAHx4_kcm5G95hD8CCnEd_AcQeY6k",
                "response"  => $_POST['g-recaptcha-response'],
                "remoteip"  => $ipaddress
                ]);
        if(!$captcha->success){
            $error = "Captcha is required!";
        }
        else{
            $continue = 1;
        }
    }
    else $continue = 1;

    //form was submitted
    if($continue){
        $username = strip_tags(strtolower(trim($_POST['username'] ?? '')));
        $password = strip_tags($_POST['password']??'');
        if(!strlen($username) || !strlen($password))
            $error = "Please enter username and password!";
        else{
            if($auth->login($_POST['username'], $_POST['password'])){
                \App\redirect('/dashboard');
                unset($_SESSION['failed']);
            }
            else{
                $error = "Username and password didn't match!";
                if(isset($_SESSION['failed'])){
                    $_SESSION['failed'] += 1;
                }
                else
                    $_SESSION['failed'] = 1;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | NUST Olympiad '17</title>
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
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script> -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#student_nust").on("change",function(){"n_yes"===$(this).val()?$("#nust_hid").show():$("#nust_hid").hide()}),$("#ambassador").on("change",function(){"a_yes"===$(this).val()?$("#amb_hid").show():$("#amb_hid").hide()});
            // function checkForm(a){return""==a.username.value?(alert("Error: Username cannot be blank!"),a.username.focus(),!1):(re=/^\w+$/,re.test(a.username.value)?""==a.pwd.value||a.pwd.value!=a.repwd.value?(alert("Error: Password fields don't match."),a.pwd.focus(),!1):a.pwd.value.length<6?(alert("Error: Password must contain at least six characters!"),a.pwd.focus(),!1):a.pwd.value==a.username.value?(alert("Error: Password must be different from Username!"),a.pwd.focus(),!1):(re=/[0-9]/,re.test(a.pwd.value)?(re=/[a-z]/,re.test(a.pwd.value)?(re=/[A-Z]/,!!re.test(a.pwd.value)||(alert("Error: password must contain at least one uppercase letter (A-Z)!"),a.pwd.focus(),!1)):(alert("Error: password must contain at least one lowercase letter (a-z)!"),a.pwd.focus(),!1)):(alert("Error: password must contain at least one number (0-9)!"),a.pwd.focus(),!1)):(alert("Error: Username must contain only letters, numbers and underscores!"),a.username.focus(),!1))}
});
</script>
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
	                <div class="row" >
    					<?php if(isset($error)): ?>
                        <div class="col-md-10 col-md-offset-1 col-xs-12">
                            <!--append errors here! -->
                                <div class="alert alert-danger"><?=$error?></div>
                        </div>
                        <?php elseif(isset($_GET['success'])): ?>
                        <div class="col-md-10 col-md-offset-1 col-xs-12">
                            <!--append errors here! -->
                                <div class="alert alert-success">
                                Your account has been registered! You'll need to verify email to continue.
                                </div>
                        </div>
                        <?php endif ?>

                    </div>
                    
					
                        <div class="col-md-6 col-md-offset-3">
                            <div class="row">
                                 <div class="col-md-10 col-md-offset-1 col-xs-12">
                                     <div class="container-fluid">
                            <form class="form-horizontal" method="POST" id="log_form" >
                                      <div class="h3">Sign In</div>
                            <br>
							<div class="form-group">
                                <div>
                                    <input id="username" name="username" placeholder="Username" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'UserName'"  required value="<?= $_POST['username']??'' ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                
                                <div class="">
                                    <input id="pwd" name="password" placeholder="Password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'"  required>
                                </div>
                            </div>
                            <?php if(isset($_SESSION['failed']) && $_SESSION['failed']>3): ?>
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6Ldgtg0UAAAAAIGYMROWOzYRwq_qKR3dFWoRbqA9"></div>
                            </div>
                            <?php endif ?>
                        <!--lol-->
                        <!--lol-->
							<!--<div class = "row">
						      
                                    <center>
                                        <a href="#">Already have an Account? Login here!</a>
                                    </center>
                              
							</div>
							<br>-->
							<div class = "row">
						    
                                <div class="form-group"> 
                                    <center>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </center>
                                </div>
								
                           
							</div>
                            <div class = "row">
						      
                                    <center>
                                        <a href="/forgot">Forgot Password</a>
                                        <span> |</span>
                                        No Account?<a href="/register" style="text-decoration: underline;">&nbsp;Register Now</a>
                                    </center>
                              
							</div>
							<br>
                        </form>
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