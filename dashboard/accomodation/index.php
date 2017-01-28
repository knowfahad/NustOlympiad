<?php
namespace Dashboard;

use Carbon\Carbon;
use Model\Model\Challan;
use Model\Model\ChallanQuery;
use Model\Model\ParticipantQuery;
require_once(__DIR__."/../../bootstrap.php");

//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();
$auth->onlyVerified();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['agree'])){
        if( !strlen($auth->getParticipant()->getAccomodationChallanID()) ){
            $participant = $auth->getParticipant();
            $gender = ($participant->getGender() == "M") ? "m" : "f";
            $challanid = "AC" . $participant->getParticipantID() .  $gender;
            $challan = new Challan();
            $challan->setChallanID($challanid);
            $challan->setAmountPayable(1000);
            $duedate = Carbon::today()->addWeeks(2)->toDateString();
            $challan->setDueDate($duedate);
            $challan->setPaymentStatus(0);
            $challan->save();

            $participant->setAccomodationChallanID($challanid);
            $participant->save();
            if(strlen($auth->getParticipant()->getAccomodationChallanID()))
                \App\redirect("/dashboard/?feedback=accomodation");
        }
        \App\redirect("/dashboard/accomodation");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation | NUST Olympiad '17</title>
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
        .arrows
        {
            width: 5em;
            height: 5em;
            /*padding: 10px;*/
            border: 0.14em solid white;
            border-radius: 50%;

            display: flex;
          align-items: center;
          justify-content: center 

        }
        .col-centered {
            float: none;
            margin: 0 auto;
        }

        .tbtn, .tbtn:hover, .tbtn:active{
            background: none;
            /*border:0;*/
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
			<img src="../../img/torch.png" widht="150px" height="150px" id="id-img-preload">
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
                    <div class="row">
                        <div class="col-md-3 col-centered col-sm-3">
                            <a href="/index.html">
                                <img src="/img/logo.png" class="img-responsive" alt="LOGO" />
                            </a>
                        </div>

                        <div class="row">
                        <div class="col-md-10 col-xs-5 col-sm-7">
							&nbsp;<a href="../">Back to Dashboard</a>
						</div>
                        <div class="col-md-2 col-xs-7 col-sm-5">
                            <div id="userId">
                                <p style="display:inline;color:orange;">User Id:<?=$auth->getParticipant()->getParticipantID()?></p><span> | </span><a href="#">Logout</a></div>
                        </div>

                        <hr>

                    </div>
                    <br>
                    <div class="row homepage">
                        <div id='errorShow' class="row">
                            <!--append errors here! -->
                        </div>
                        <?php if( !strlen($auth->getParticipant()->getAccomodationChallanID()) ):  ?>
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-12  col-xs-12">
                                    <div class="container-fluid">
                                        <center>
                                            <h2 style="font-family:Montserrat font-weight:200;color:orange;">Instructions for Accommodation</h2>
                                        </center>
                                        <br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 ">
                                <div id="makeborder" style="font-family:Montserrat-Light;">
                                    <ul style = "text-align:left;line-height:25px;">
                                        <li>The accommodation charges are Rs.1000.</li>
                                        <li>Accommodation will be given on first come first serve basis.</li>
                                        <li>Participants are required to stay in their respective residing areas. All the rules for participants
                                            are same as those applicable for the NUST Hostelities.</li>
                                        <li> You are advised to be inside university premises by 2200 hours, whereas hostel gates will strictly
                                            close at 2230 hours and attendance will be marked.</li>
                                        <li>Breakfast will be the only meal provided to the participants between timings 0700 – 0900 Hours.</li>
                                        <li>Laundry service, available to all participants, can be found on the first floor from 0830 – 2200
                                            Hours.</li>
                                        <li>Carry your valuables with you at all times and keep your luggage locked while unattended.</li>
                                        <li>University will not be responsible for any loss or theft of valuables.</li>
                                        <li>Be considerate of others’ comfort and adhere to the lowest of noise levels.</li>
                                        <li>In case of any property damage, the defaulter would be liable for compensation.</li>
                                        <li>In case of any emergency, participants may leave after getting the permission of the warden,
                                        obtaining an out pass and informing the respective hostel accommodation team member.</li>
                                        <li>DRUGS/Weaponry of any kind is not allowed inside NUST premises. Anyone found having them
                                        would immediately be removed from campus.</li>
                                        <li>Smoking is prohibited on campus.</li>
                                        <li>For further queries, contact respective accommodation team members.</li>

                                        
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
                                       <div >
                                      <!-- <a href="#"> <i class="fa fa-angle-left arrow-inside"></i></a>
                                       </div> -->
                                      <a class="arrows btn btn-primary tbtn" href="/dashboard"> Go Back </a>
                                   </center>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                   <center>
                                       <div>
                                       <form method="POST">
                                        <div class="form-group">
                                            <button class=" arrows btn btn-primary tbtn" value="yes" name="agree">
                                            <!-- <i class="fa fa-angle-right arrow-inside"></i> -->
                                            I agree</button>
                                        </div>
                                       </form>
                                       </div>
                                   </center>
                                </div>
                            </div>
                        </div>
                        </div>
                        <?php else: ?>
                        <center>
                        <h2 styles="text-align: center;">Your challan has already been generated!</h2>
                        <?php endif ?> 
                        </center>
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
            <!--<script src="/js/classie.js"></script>-->
            <script src="/js/detectanimation.js"></script>
            <script src="/js/modernizr.custom.js"></script>
            <!-- preloading flame js-->
   <script type="text/javascript" src="../../js/flame.js"></script>
</body>

</html>