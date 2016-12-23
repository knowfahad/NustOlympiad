<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events | NUST Olympiad '17</title>
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
    <title>Sports | NUST Olympiad '17</title>
    <script type="text/javascript" src="/js/jquery.min.js"></script>
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
                    <div class="row">
                        <div class="col-md-3 col-centered col-sm-3">
                           
                                <img src="/img/logo.png" class="img-responsive" alt="LOGO" />
                            
                        </div>
                    </div>
                    <div class="row homepage">
                        <div id='errorShow' class="row">
                            <!--append errors here! -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-xs-5 col-sm-7"></div>
                        <div class="col-md-2 col-xs-7 col-sm-5">
                            <div id="userId">
                                <p style="display:inline;color:orange;">User Id:33456</p><span> | </span><a href="#">Logout</a></div>
                        </div>
                        <hr>
                    </div>
						
                    <div class="row">
                      <div class = "col-md-1"></div>
                            <div class="col-md-10 my-box ">
                                <h4 style="text-align:left;">Select an Event</h4>
                                <br>
								<br>
                                <!--new -->
                                <div class="row">
									<form method="POST">
                                    <div class = "col-md-2 col-xs-3"></div>
									<div class = "col-md-8 col-xs-6">
									<center>
									<div class = "row">
										
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "1"   class="my-radio" > Crime Line Road 
											</label>
										</div>
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "2"   class="my-radio" > Mathletics 
											</label>
										</div>
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "3"    class="my-radio" > Human Foosball 
											</label>
										</div>
										
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "4"   class="my-radio" > E-Gaming 
											</label>
										</div>
										
									
									</div>
									<br>
									<div class = "row">
									
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "5" class="my-radio"    > Speed Programming 
											</label>
										</div>
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "6" class="my-radio"    > Minute to win it 
											</label>
										</div>
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "7" class="my-radio" > Public Speaking Challenge 
											</label>
										</div>
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "8" class="my-radio"    > Archery 
											</label>
										</div>
									
									
									</div>
                                    <br>

                                    <div class = "row">
									
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "9" class="my-radio"    > Paintball 
											</label>
										</div>
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "10" class="my-radio"    > Product Photography 
											</label>
										</div>
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "11" class="my-radio" > Live Charcoal   
											</label>
										</div>
										<div class = "col-md-3">
											<label>
												
											<input type="radio" name="eventname" value = "12" class="my-radio"    > Graffiti 
											</label>
										</div>
									
									
									</div>
                                    <br>

                                    <div class = "row">
									
										<div class = "col-md-3">
											<input type="radio" name="eventname" value = "13" class="my-radio"    > Hurdle Marathon 
										</div>
										<div class = "col-md-3">
											<input type="radio" name="eventname" value = "14" class="my-radio"    > Funkaar 
										</div>
										<div class = "col-md-3">
											<input type="radio" name="eventname" value = "15" class="my-radio" > Essay Writing   
										</div>
										<div class = "col-md-3">
											<input type="radio" name="eventname" value = "16" class="my-radio"    > Pair 'Em Up' 
										</div>
									
									
									</div>
                                    <br>

                                     <div class = "row">
									
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "17" class="my-radio"    > Gun Shooting
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "18" class="my-radio"    > Qirat 
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "19" class="my-radio" > Individual Competition 
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "20" class="my-radio"    > Olymiad Feud
											</label>
										</div>
									
									
									</div>
                                    <br>

                                    <div class = "row">
									
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "21" class="my-radio"    > Sumo Knockdown
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "22" class="my-radio"    > Footy Mania
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "23" class="my-radio" > The Egg Rover Mission  
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "24" class="my-radio"    > Catch the flag
											</label>
										</div>
									
									
									</div>
                                    <br>

                                    <div class = "row">
									
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "25" class="my-radio"    > Bait Baazi
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "26" class="my-radio"    > Wall Climbing 
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "27" class="my-radio" > The Egg Rover Mission  
											</label>
										</div>
										<div class = "col-md-3">
											<label for="">
												
											<input type="radio" name="eventname" value = "28" class="my-radio"    > Catch the flag 
											</label>
										</div>
									
									
									</div>
                                    <br>
									</center>
									</div>
									<div class = "col-md-2 col-xs-3"></div>
                                </form>
                                </div>

                                <!--new-->
                            </div>
					  <div class = "col-md-1"></div>
                     
                    </div>
                    <br>
                    <br>

					
                    
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