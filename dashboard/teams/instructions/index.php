<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructions | NUST Olympiad '17</title>
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
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script> -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#student_nust").on("change",function(){"n_yes"===$(this).val()?$("#nust_hid").show():$("#nust_hid").hide()}),$("#ambassador").on("change",function(){"a_yes"===$(this).val()?$("#amb_hid").show():$("#amb_hid").hide()});
            // function checkForm(a){return""==a.username.value?(alert("Error: Username cannot be blank!"),a.username.focus(),!1):(re=/^\w+$/,re.test(a.username.value)?""==a.pwd.value||a.pwd.value!=a.repwd.value?(alert("Error: Password fields don't match."),a.pwd.focus(),!1):a.pwd.value.length<6?(alert("Error: Password must contain at least six characters!"),a.pwd.focus(),!1):a.pwd.value==a.username.value?(alert("Error: Password must be different from Username!"),a.pwd.focus(),!1):(re=/[0-9]/,re.test(a.pwd.value)?(re=/[a-z]/,re.test(a.pwd.value)?(re=/[A-Z]/,!!re.test(a.pwd.value)||(alert("Error: password must contain at least one uppercase letter (A-Z)!"),a.pwd.focus(),!1)):(alert("Error: password must contain at least one lowercase letter (a-z)!"),a.pwd.focus(),!1)):(alert("Error: password must contain at least one number (0-9)!"),a.pwd.focus(),!1)):(alert("Error: Username must contain only letters, numbers and underscores!"),a.username.focus(),!1))}
});
</script>
    <style>
        a {
            color: white;
        }
        
        a:hover,
        a:focus {
            color: white;
        }
        
        input {
            color: white;
        }
        
        label {
            font-weight: normal;
        }
        
        .col-centered {
            float: none;
            margin: 0 auto;
        }
        
        #makeborder {
            border-style: solid;
            border-color: white;
            /*background-color: transparent;*/
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-width: 1px;
            padding: 2%;
            text-align: center;
        }
    </style>
</head>

<body id="id-body">
    <div class="td-preloading">
        <!-- <span class="fa fa-spinner fa-spin"></span> -->
		
			<canvas id="c" width="300px" height="300px" ></canvas>
			<img src="../../../img/torch.png" widht="150px" height="150px" id="id-img-preload">
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
                    <div class="row">
                        <div class="col-md-3 col-centered col-sm-3">
                            <a href="../index.html">
                                <img src="/img/logo.png" class="img-responsive" alt="LOGO" />
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="row homepage">
                        <div id='errorShow' class="row">
                            <!--append errors here! -->
                        </div>
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-12  col-xs-12">
                                    <div class="container-fluid">
                                        <center>
                                            <h2 style="font-family:Montserrat font-weight:200;">Read instructions before proceeding</h2>
                                        </center>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2">
                                <div id="makeborder" style="font-family:Montserrat-Light;">
                                    <ul style = "text-align:left; line-height:25px;">
                                        <li>You can register only for team events here. </li>
                                            <li>The captain of the team must register the entire team.</li>
                                        <li>The applicant creating the team, i.e. the captain, <span style = "color:orange;">SHOULD add him/herself</span> in the team by clicking on the add yourself button.</li>
                                        <li>Add a new member in the team or search for an existing member using only <span style = "color:orange;">User ID</span>
                                            provided by portal.</li>
                                            
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                   <center>
                                       <div class="arrows">
                                      <a href="/dashboard/"> <i class="fa fa-angle-left arrow-inside"></i></a>
                                       </div>
                                      <a href="/dashboard"> Go Back </a>
                                   </center>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                   <center>
                                       <div class="arrows">
                                     <a href="/dashboard/teams/"> <i class="fa fa-angle-right arrow-inside"></i></a>
                                       </div>
                                      <a href="/dashboard/teams/"> Proceed </a>
                                   </center>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="/js/jquery.min.js"></script>
            <script type="text/javascript">
   		$(document).ready(function(){
   			function setPreLoadMargin(){
   				var width = $(window).width();
   				
   				$('#c').css({"position":"absolute","left":((width-300)/2)+"px"});
   				$('#id-img-preload').css({"position":"absolute","top":"50%","left":((width-95)/2)+"px"});
   			}
   			setPreLoadMargin();
   			$(window).resize(function(){setPreLoadMargin();});

   		});
   </script>
            <script src="/js/responsive.js"></script>
            <script src="/js/perfect-scrollbar.min.js"></script>
            <script src="/js/bootstrap.min.js"></script>
            <script src="/js/jquery.visible.min.js"></script>
            <script src="/js/scriptdemo3.js"></script>
            <script src="/js/classie.js"></script>
            <script src="/js/detectanimation.js"></script>
            <script src="/js/modernizr.custom.js"></script>
            <!-- preloading flame js-->
   <script type="text/javascript" src="../../../js/flame.js"></script>
</body>

</html>