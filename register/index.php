<?php
namespace Register;
require_once "../bootstrap.php";
include_once '../OlAssets/dbconnect.php';
include_once 'random_compat-master/lib/random.php';
$auth->onlyGuests();
$formsubmitted = $_SERVER['REQUEST_METHOD'] == 'POST'; //saved it as have to use later as well
if ($formsubmitted){
    list($errors, $data) = preprocess($mpdo);
    if(!count($errors)){
        $errors = persistUser($data, $mpdo);
        if(!count($errors))
                \App\redirect("/login");
    }   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | NUST Olympiad '17</title>
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
    <title>Register</title>
   
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
        <!-- <span class="fa fa-spinner fa-spin"></span> -->
		
			<canvas id="c" width="300px" height="300px" ></canvas>
			<img src="../img/torch.png" widht="150px" height="150px" id="id-img-preload">
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
    					<?php if( $formsubmitted && count($errors) ): ?>
                        <div class="col-md-10 col-md-offset-1 col-xs-12">
                            <!--append errors here! -->
                                <?php foreach($errors as $field => $error): ?>
                                <div class="alert alert-danger"><?=$error?></div>
                                <?php endforeach ?>
                        </div>
                        <?php endif ?>
                    </div>
					
                        <div class="col-md-6">
                            <div class="row">
                                 <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1">
                                     <div class="container-fluid">
                            <form class="form-horizontal" method="POST" id="reg_form" enctype="multipart/form-data" >
                                      <div class="h3">Create an Account</div>
                            <br>
                            
							<div class="form-group">
                                <div class = row>
                                    <div class = "col-md-3 col-xs-5">
                                        <label for="rg-from">Username:</label>
                                        </div>
                                        <div class = "col-md-9 col-xs-7">
                                    <input id="username" name="username" placeholder="Min 3 characters" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Min 3 characters'"  required value="<?=$_POST['username']??''?>"
                                    >
                                    </div>
                                </div>
                            </div>

                            
                            <div class="form-group">
                                <div class = row>
                                <div class = "col-md-3 col-xs-5">
                                    <label for="pwd">Password:</label>
                                        </div>
                                        <div class = "col-md-9 col-xs-7">
                                    <input id="pwd" name="pwd" placeholder="Min 8 characters" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Min 8 characters'"  required>
                                </div>
                            </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class = "col-md-3 col-xs-5">
                                    <label for="repwd">Repeat Password:</label>
                                        </div>
                                    <div class="col-md-9 col-xs-7">
                                        <input id="repwd" name="repwd" placeholder="Re-Enter Password" type="password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Re-Enter Password'" required>
                                    </div>
                                </div>
                            </div>
                            
                             

                            <div class="form-group">
                                <div class="row">
                                    <div class = "col-md-3 col-xs-5">
                                    <label for="fname">First Name:</label>
                                        </div>
                                <div class="col-md-9 col-xs-7">
                                    <input id="fname" name="fname" placeholder="First Name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'" required value="<?=$_POST['fname']??''?>" >
                                </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    <div class = "col-md-3 col-xs-5">
                                    <label for="lname">Last Name:</label>
                                        </div>
                                <div class="col-md-9 col-xs-7">
                                    <input  id="lname" name="lname" placeholder="Last Name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'" required value="<?=$_POST['lname']??''?>">
                                </div>
                                </div>
                            </div>
                          

							<div class = "row">
								<div class="form-group">
								
									<div class="col-md-4 col-xs-3">
									<label  for="name">Gender</label>
									</div>
									
									<div class="col-md-4 col-xs-4"> 
									<label><input <?php if(isset($_POST['gender'])  && $_POST['gender'] == "M"): ?> checked="checked" <?php endif ?> type="radio" value = "M" name="gender" required> Male</label>
									</div>
									
									<div class="col-md-4 col-xs-5"> 
									<label><input type="radio" <?php if(isset($_POST['gender']) && $_POST['gender'] == "F"): ?> checked="checked" <?php endif ?> name="gender" value="F"  required> Female</label>
									</div>
									
								</div>
							</div>

                            <div class="form-group">
                                <div class = "row">
                                    <div class = "col-md-3 col-xs-3">
                                    <label for="email">Email:</label>
                                        </div>
                                <div class="col-md-9 cl-xs-9">
                                    <input id="email" name="email" placeholder="name@example.com" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'name@example.com'" required value="<?=$_POST['email']??''?>" >
                                </div>
                                </div>
                            </div>
							
                            <!--end label -->
                            <div class="form-group">
                                <div class="row">
                                    <div class = "col-md-3 col-xs-3">
                                    <label for="cnic">CNIC:</label>
                                        </div>
                                <div class="col-md-9 cl-xs-9">
                                    <input id="cnic" name="cnic" placeholder="CNIC/ B.Form Number (Without Dashes)" type="number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'CNIC/ B.Form Number (Without Dashes)'" required value="<?=$_POST['cnic']??''?>" >
                                </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class ="row">
                                    <div class = "col-md-3 col-xs-7">
                                    <label for="mobile">Mobile No:</label>
                                        </div>
                                <div class="col-md-9 cl-xs-5">
                                    <input id="mobile" name="mobile" placeholder="Format: 03xxxxxxxxx" type="number" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Format: 03xxxxxxxxx'" required value="<?=$_POST['mobile']??''?>" >
                                </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class = "row">
                                    <div class = "col-md-3 col-xs-3">
                                    <label for="address">Address:</label>
                                        </div>
                                <div class="col-md-9 cl-xs-9"> 
                                    <input id="address" name="address" placeholder="Address" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Address'" required value="<?=$_POST['address']??''?>" >
                                </div>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 1%">
                                <div class = "row">
                                    <div class = "col-md-3 col-xs-3">
                                    <label for="institute">Institute:</label>
                                        </div>
                                <div class="col-md-9 cl-xs-9"> 
                                    <input id="institute" name="institute" placeholder="Institute" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Institute'" required value="<?=$_POST['institute']??''?>" >
                                </div>
                                </div>
                            </div>
                        
						
						
						<div class= "row">
						<div class="makeinline form-group" >

							<p class="col-md-9 col-xs-6" style="color:white;">Are You a NUSTian?</p>
                            <select class="col-md-4 selectpicker form-control selectWidth" name="isNustian" id="student_nust" style="background-color:#757575;">
                                <option value="n_no"  
                                <?php 
                                if( !((isset($_POST['isNustian']) && $_POST['isNustian'] != "n_yes")) ): ?>
                                 selected="selected"
                                <?php endif ?>
                                 >No</option>
                                <option value="n_yes" style="color:black;"
                                <?php
                                if( !((isset($_POST['isNustian']) && $_POST['isNustian'] != "n_yes")) ): ?>
                                 selected="selected"
                                <?php endif ?>
                                >Yes</option>
                            </select>
                         </div>   
                        </div>
						
						<br>
						
						<div class= "row">
                        <div class="form-group hidden_items" id="nust_hid"
                        <?php if(!(isset($_POST['isNustian']) && $_POST['isNustian'] == "n_yes")): ?>
                        style="display:none;" 
                        <?php endif ?>
                        >
                                <div class=""> 
                                    <input id="nust_id" name="nustid" placeholder="Enter CMS ID" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter CMS ID'"
                                    <?php if((isset($_POST['isNustian']) && $_POST['isNustian'] == "n_yes")): ?>
                                        value="<?=$_POST['nustid'] ?? '' ?>"
                                    <?php endif ?>
                                    >
                                </div>
                        </div>
						</div>
                          
						<div class= "row">
                            <div class="form-group makeinline" >
                                <p class="col-md-9 col-xs-7" style="color:white;">Are You an Ambassador?</p>
                            <select class="col-md-3 col-xs-5 form-control selectWidth selectpicker" name="ambassador" id="ambassador" style="background-color:#757575;;">
                                    <option value="a_no" 
                                    <?php 
                                    if( (isset($_POST['ambassador']) && $_POST['ambassador'] != "a_yes") ): ?> selected <?php endif ?> >No</option>
                                    <option value="a_yes" <?php if(isset($_POST['ambassador']) && $_POST['ambassador'] == "a_yes"): ?> selected <?php endif ?>>Yes</option>
                            </select>

                            </div>
						</div>
						
						<div class= "row">
                            <div class="form-group hidden_items" id="amb_hid" 
                            <?php if(!(isset($_POST['ambassador']) && $_POST['ambassador'] == "a_yes")): ?>
                            style="display:none;" 
                            <?php endif ?>
                            >
                               <br>
                                    <input id="amb_id" name="ambassadorid" placeholder="Enter Ambassador ID" type="text"  onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Ambassador ID'"

                                <?php if((isset($_POST['ambassador']) && $_POST['ambassador'] == "a_yes")): ?>
                                    value="<?=$_POST['ambassadorid'] ?? '' ?>"
                                        <?php endif ?>
                                        
                                    >
                               
                            </div>
						</div>
                            <br>
						    
							<div class = "row">
								<div class="form-group makeinline" >
							   
									<h5 class="col-md-4 col-xs-6 makeline" style="color:white; font-weight:normal;">Upload an image</h5>
                                    <br>
									<input class="col-md-8 col-xs-6"   name="img" accept="image/*" type="file">
								</div>
                            </div>
                            <br>
                            <div class = "row">
                                <p style="color:orange;">*Image must be in JPEG or JPG format and 2 MB max.</p>
                                </div>

                            <div class="form-group row">
                                <div class="g-recaptcha col-md-6 cl-md-offset-3" data-sitekey="6Ldgtg0UAAAAAIGYMROWOzYRwq_qKR3dFWoRbqA9"></div>
                            </div>
                        
							<div class = "row">
						      
                                    <center>
                                        <a href="/login">Already have an Account? Login here!</a>
                                    </center>
                              
							</div>
							<br>
							<div class = "row">
						    
                                <div class="form-group"> 
                                    <center>
                                        <button type="submit" class="btn btn-default">Submit</button>
                                    </center>
                                </div>
								
                           
							</div>
                        </form>
                                     </div>
                                 </div>
                            </div>
                        </div>
                         <div class="col-md-6 col-xs-12">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-xs-12">
                    <div class="h3">Instructions</div>
                    <br>
                    <div id = "makeborder" style="text-align: left; line-height: 25px;    padding-left: 2%;" >
                    <ul>
                            <li>Users will register for the Olympiad events and socials by creating and then logging into their individual accounts.</li>
                            <li>For team registrations, all team members must first individually register themselves on the online portal.</li>
                            <li>Only ONE account per CNIC is allowed.</li>
                            <li>Upload a clear and recent picture of yourself.</li>
                            <li>ALL fields are mandatory to fill in. </li>
                            <li>Carefully enter your details in the spaces provided below, as once the form is submitted, you will NOT be able to change the details.</li>
                            <li>If you are a student of NUST, enter your CMS ID to sign in and access the form.</li>
                            <li>If you are an ambassador, use your ambassador ID to sign in.</li>
                            <li>The registration fee is COMPULSORY. Your registration will not be considered without it. Moreover, other challans will be void and entry to NUST will not be allowed.</li>
                            <li>Only paid and verified challans will be considered. Once they are paid, the fee will be non-refundable.</li>
                            <li>Challans might take up to 2 working days to be verified.</li>
                            <li>Each participant must apply individually for accommodation.</li>
                            <li>Accommodation is limited and hence will be provided on first-come, first-served basis.</li>
                            <li>The social event, ‘Theme Dinner’ is free of cost for all participants of the NUST Olympiad 2017. </li>
                            <li>In case of any query, please contact: </li>
                            Director Registrations : 0343 1551217<br>
							Deputy Director Registrations: 0334 3631447<br>
							Deputy Director Registrations: 0322 7211379<br>
							Director External Registrations : 0323 5315135  <br>
							Deputy Director External Relations: 03339254563 <br>
                            
                        </ul>
            </div>
                </div>
            </div>
        </div>
                    </div>
                </div>
            </div>
            <script src="../js/jquery.min.js"></script>
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
            <script src="../js/responsive.js"></script>
            <script src="../js/perfect-scrollbar.min.js"></script>
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/jquery.visible.min.js"></script>
            <script src="../js/scriptdemo3.js"></script>
            <script src="../js/classie.js"></script>
            <script src="../js/detectanimation.js"></script>
            <script src="../js/modernizr.custom.js"></script>
           
            <script type="text/javascript" src="../js/timeline.js"></script>
            <!-- preloading flame js-->
   <script type="text/javascript" src="../js/flame.js"></script>
           
</body>
</html>