<?php 
require_once(__DIR__."/../../bootstrap.php");
$auth->onlyLoggedIn();
if($auth->User()->isVerified()){
    \App\redirect("/dashboard");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | NUST Olympiad '17</title>
    <link rel="stylesheet" type="text/css" href="../css/timeline.css">
    
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
						<img src="/img/logo.png" class="img-responsive" alt="LOGO"/>
					</a>	
					
					</div>
				</div> 
                <br>
                
				
                    <div class="row homepage" >
					<div  id =  'errorShow' class = "row">
					
					<!--append errors here! -->
					
					</div>
					
                        <div class="col-md-10 col-md-offset-1">
                            
                            <div class="row">
                                 <div class="col-md-12  col-xs-12">
                                     <div class="container-fluid">
                                         <center><h2>Please verify your email to continue</h2></center>
                                         <br><br>
                                         <h4 style="text-align:center;">To complete your registration, please check your email for account activation instructions.</h4><p style="text-align:center;">Make sure to check your spam-folder, the activation email might be marked as spam!<br><a href="/register/resend" style="text-decoration: underline;">Resend email</a> | <a href="../../logout">Logout</a></p>
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
         
</body>

</html>