<?php 
namespace Dashboard;
require(__DIR__ . '/../bootstrap.php');
//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();
$auth->onlyVerified();
$challans = \Dashboard\getChallans($auth, $mpdo);
$accomodationChallan = accomodationChallan($auth, $mpdo);
$registrationChallan = registrationChallan($auth, $mpdo);
$teams = enrolledTeams($auth, $mpdo);
$teamChallans = teamChallans($auth, $mpdo);

if(!$auth->getParticipant()->isPaid()){
    $errorMessage = "You must pay the registration challan to complete registration!";
}

$message = 0;

if(isset($_GET['feedback'])){
    switch($_GET['feedback']){
        case "accomodation":
        $message = "Your accomodation challan has been generated successfully!";
        break;
        case "team":
        $message = "Your team challan has been generated successfully!";
        break;
        case "event":
        $message = "Your challan has been generated successfully!";
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | NUST Olympiad '17</title>
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
        
        .my-box {
            border-style: solid;
            border-color: white;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-width: 1px;
            padding: 2%;
        }
        .my-btn
        {
            background-color: transparent;
            color:white;
            border-radius: 0 !important;

        }
    </style>
</head>

<body id="id-body">
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
                    <div class="row">
                        <div class="col-md-3 col-centered col-sm-3">
                           
                                <img src="/img/logo.png" class="img-responsive" alt="LOGO" />
                            
                        </div>
                    </div>
                    <div class="row homepage">
                            <?php if($message): ?> 
                            <div id='errorShow' class="row">
                                <div class="col-md-8 col-md-offset-2 alert alert-success">
                                    <?=$message?>
                                </div>
                            </div>
                            <?php endif ?>
                            <?php if(isset($errorMessage)): ?> 
                                <div id='errorShow' class="row">
                                <div class="col-md-8 col-md-offset-2 alert alert-danger">
                                    <?=$errorMessage?>
                                </div>
                                </div>
                            <?php endif ?>
            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-xs-5 col-sm-7">
                        </div>
                        <div class="col-md-2 col-xs-7 col-sm-5">
                            <div id="userId">
                                <p style="display:inline;color:orange;">User Id:<?=$auth->getParticipant()->getParticipantID()?></p><span> | </span><a href="/logout">Logout</a></div>
                        </div>
                        <hr>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <div class="my-box">
                                <h4 style="text-align:left;">Register</h4>
                                <br>
                                <!--new -->
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4 col-xs-10">
                                        <a href="/dashboard/teams/instructions" class="btn btn-default btn-sm my-btn">
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teams Events&nbsp;&nbsp;&nbsp;&nbsp;
                                        </a>
                                        </div>
                                    <div class="col-md-4 col-xs-8">
                                        <a href="/dashboard/individual" class="btn btn-default btn-sm my-btn">
                                          Individual Events 
                                        </a>
                                    </div>
                                    <div class="col-md-2 col-xs-1"></div>
                                    <br>
                                    <br>
                                </div>
                                <!--new-->
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="my-box">
                                <h4 style="text-align:left;">Pay for</h4>
                                <br>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-4 col-xs-10">
                                        <a href="/dashboard/social" class="btn btn-default btn-sm my-btn">
                                          SOCIAL EVENTS 
                                        </a>
                                        </div>
                                    <div class="col-md-4 col-xs-8">
                                    <a href="/dashboard/accomodation" class="btn btn-default btn-sm my-btn">
                                      ACCOMODATION
                                    </a>
                                    </div>
                                    <div class="col-md-2 col-xs-1"></div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>

                    
                    <div class="row clearfix">
                        <div class="col-md-6 col-xs-12">
                            <div class="my-box challans">
                                <h4 style="text-align:left;">Challans</h4>
                                <br>

                               <!-- insert challans here-->
                                
                                <div class="row" id = "challans clearfix"> 
                                    <div class="col-md-8 col-md-offset-2">
                                        <?php if($registrationChallan): ?>
                                        <div class="challan_item <?=($registrationChallan['PaymentStatus'])?"paid":"unpaid" ?>">
                                            <h5>Registration Challan</h4>
                                            <div class="challan-buttons">
                                                <?php if(!$registrationChallan['PaymentStatus']): ?>
                                                <form method="POST" action="http://ol-challan-generator.herokuapp.com/">
                                                    <input type="hidden" value="registration" name="eventname">
                                                    <input type="hidden" value="<?= $registrationChallan['ChallanID'] ?>" name="challanid">
                                                    <input type="hidden" value="<?= $registrationChallan['DueDate'] ?>" name="duedate">
                                                    <input type="hidden" value="registration" name="eventname">
                                                    <input type="hidden" value="<?= $registrationChallan['AmountPayable'] ?>" name="fee">
                                                    <input type="hidden" value="registration" name="type">
                                                    <button class="btn btn-xs btn-default" type="submit">Print</button> 
                                                </form>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                        <?php endif ?>


                                        <?php if($accomodationChallan): ?>
                                        <div class="challan_item <?=($accomodationChallan['PaymentStatus'])?" paid ":" unpaid " ?>" >
                                            <h5>Accomodation Challan</h4>
                                            <?php if(!$accomodationChallan['PaymentStatus']): ?>
                                            <div class="challan-buttons">
                                                <form method="POST" action="http://ol-challan-generator.herokuapp.com/">
                                                    <input type="hidden" value="Accomodation" name="eventname">
                                                    <input type="hidden" value="<?= $accomodationChallan['ChallanID'] ?>" name="challanid">
                                                    <input type="hidden" value="<?= $accomodationChallan['DueDate'] ?>" name="duedate">
                                                    <input type="hidden" value="Accomodation" name="eventname">
                                                    <input type="hidden" value="<?= $accomodationChallan['AmountPayable'] ?>" name="fee">
                                                    <input type="hidden" value="accomodation" name="type">
                                                    <button class="btn btn-xs btn-default" type="submit">Print</button> 
                                                </form>
                                                <form method="POST" action="/dashboard/challans/delete.php">
                                                    <input type="hidden" name="challanid" value="<?=$accomodationChallan['ChallanID'] ?>">
                                                    <button class="btn btn-xs btn-danger" type="submit">Delete</button> 
                                                </form>
                                            </div>
                                            <?php endif ?>
                                        </div>
                                        <?php endif ?>

                                                 
                                     <?php foreach($challans as $challan): ?>
                                         <div class="challan_item <?=($challan['PaymentStatus'])?"paid":"unpaid" ?>">
                                             <h5><?=$challan['Name']?></h4>
                                             <div class="challan-buttons">
                                                 <?php if(!$challan['PaymentStatus']): ?>
                                                 <form method="POST" action="http://ol-challan-generator.herokuapp.com/">
                                                     <input type="hidden" value="<?= $challan['Name'] ?>" name="eventname">
                                                     <input type="hidden" value="<?= $challan['ChallanID'] ?>" name="challanid">
                                                     <input type="hidden" value="<?= $challan['DueDate'] ?>" name="duedate">
                                                     <input type="hidden" value="<?= $challan['Name'] ?>" name="eventname">
                                                     <input type="hidden" value="<?= $challan['EventFee'] ?>" name="fee">
                                                     <input type="hidden" value="<?php
                                                     if($challan['EventType'] == 1)
                                                         echo "Individual Event"; 
                                                     elseif($challan['EventType'] == 2)
                                                         echo "Social Event";
                                                     ?>" name="type">
                                                     <button class="btn btn-xs btn-default" type="submit">Print</button> 
                                                 </form>
                                                 <form method="POST" action="/dashboard/challans/delete.php">
                                                     <input type="hidden" name="challanid" value="<?=$challan['ChallanID'] ?>">
                                                     <button class="btn btn-xs btn-danger" type="submit">Delete</button> 
                                                 </form>
                                                 <?php endif ?>
                                             </div>

                                         </div>
                                     <?php endforeach ?>

                                     <?php if(count($teamChallans)): ?>
                                     <?php foreach($teamChallans as $challan): ?>
                                         <div class="challan_item   
                                         <?=($challan['PaymentStatus'])?"paid":"unpaid" ?>">
                                             <h5><?=$challan['TeamName']?></h5>
                                             <div class="challan-buttons">
                                                 <?php if(!$challan['PaymentStatus']): ?>
                                                 <form method="POST" action="http://ol-challan-generator.herokuapp.com/">
                                                     <input type="hidden" value="Sports team: <?=$challan['TeamName']?>" name="eventname">
                                                     <input type="hidden" value="<?= $challan['ChallanID'] ?>" name="challanid">
                                                     <input type="hidden" value="<?= $challan['DueDate'] ?>" name="duedate">
                                                     <input type="hidden" value="<?= $challan['AmountPayable'] ?>" name="fee">
                                                     <input type="hidden" value="Sports" name="type">
                                                     <button class="btn btn-xs btn-default" type="submit">Print</button> 
                                                 </form>
                                                 <form method="POST" action="/dashboard/challans/delete.php">
                                                     <input type="hidden" name="challanid" value="<?=$challan['ChallanID'] ?>">
                                                     <button class="btn btn-xs btn-danger" type="submit">Delete</button> 
                                                 </form>
                                                 <?php endif ?>
                                             </div>

                                         </div>

                                     <?php endforeach ?>
                                     <?php endif ?> 
                                                  
                                        <!-- </div> -->
                                    </div>
                                
                                </div>
                                <!--challans div ended-->
                                    
                                <br>
                                <br>
                                
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="my-box">
                                <h4 style="text-align:left;">Team Member History</h4>
                                <br>

                                <!--append team history here-->
                                <div class="row" id = "teamhistory">
                                    <?php if(count($teams)): ?>
                                    <ul>

                                    <?php foreach($teams as $team): ?>
                                    <li>
                                    <h4><?=$team->TeamName?></h4>
                                    <ul>
                                        <?php foreach($team->members() as $member): ?>

                                        <li>
                                            <?=$member->FirstName?> <?=$member->LastName?>
                                        </li>

                                        <?php endforeach ?>
                                    </ul>
                                    </li>
                                    <?php endforeach ?>
                                    </ul>
                                    <?php endif ?>
                                </div>
                                <!--team history div ended-->

                                <br>
                                <br>
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