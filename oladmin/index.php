<?php 
require_once(__DIR__."/bootstrap.php");

$auth->onlyAdmin();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Admin Panel </title>

        <link href="favicon1.ico" rel="icon" type="image/x-icon" />

        <!-- ===== STYLESHEETS START ===== -->
        <!-- Bootstrap style sheet -->
        <link rel="stylesheet" href="/css/bootstrap.min.css" />

        <!-- Font Awesome style sheet -->
        <link rel="stylesheet" href="/css/font-awesome.min.css">

        <!-- Theme specific style sheets -->
        <link rel="stylesheet" href="/css/styles.css" id="theme-css" />

        <!-- ===== STYLESHEETS END ===== -->
    </head>
    <body>
        <!-- ===== PAGE START ===== -->
        <header>
            <!-- Top navbar start -->
            <nav class="navbar navbar-default navbar-transparent">
                <div class="container" id="nav-container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    
                </div><!-- /.container-fluid -->
            </nav>    
            <!-- Top navbar end -->
        </header>
        <!-- Content container start -->
        <div class="container" id="content-container">
            <div class="content-wrapper">
                <div class="row">
                    <!-- Side menu + Content start -->
                    <div class="side-nav-content">
                        <!-- Side menu start -->
                        <div class="left-side-wrapper">
                            <!-- left side start-->
                            <div class="left-side sticky-left-side">
                                <div class="left-side-inner">
                                    <!--sidebar nav start-->
                                  
                                    <!--sidebar nav end-->

                                </div>
                            </div>
                            <!-- left side end-->
                        </div>
                        <!-- Side menu end -->
                        <!-- Main content wrapper start -->
                        <div class="main-content-wrapper">
                            <div class="container-fluid container-padded dash-controls">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-right">
                                            <div id="reportrange">
                                            </div>
                                        </div>
                                        </div>
                                </div>
                            </div>
                            <!-- Main content start -->
                            <div class="main-content">
                            <!-- Section 1 start -->
                                <section>
                                    <!-- Section container start -->
                                    <div class="container-fluid container-padded">
                                        <div class="row">
											
										<a href="/oladmin/registration" id="reg_challan">
                                            <div class="col-xs-6 col-sm-6 col-md-3">
                                                <div class="panel panel-default">
                                                    <div class="panel-body panel-body-top-br" style="background-color:#FFC300;">
                                                        <div class="stat">
                                                            <h3 class="stat-value">Registration Challan</h3>
                                                        </div>
                                                    </div> <!-- panel body end -->
                                                </div> <!-- panel end -->
                                            </div> <!-- col end -->
											</a>
										
										<a href="./team" id="team_challan">
                                            <div class="col-xs-6 col-sm-6 col-md-3">
                                                <div class="panel panel-default">
                                                    <div class="panel-body panel-body-top-br" style="background-color:#FFC300;">
                                                        <div class="stat">
                                                            <h3 class="stat-value">Team Challan</h3>
                                                        </div>
                                                    </div> <!-- panel body end -->
													<div class="panel-body panel-body-top-br" style="background-color:#FFC300;"></div> <!-- panel body end -->
                                                </div> <!-- panel end -->
                                            </div> <!-- col end -->
											</a>
											
										 <a href="./individual" id="individual_challan">
                                            <div class="col-xs-6 col-sm-6 col-md-3">
                                                <div class="panel panel-default">
                                                    <div class="panel-body panel-body-top-br" style="background-color:#FFC300;">
                                                        <div class="stat">
                                                            <h3 class="stat-value">Individual Challan</h3>
                                                        </div>
                                                    </div> <!-- panel body end -->
                                                </div> <!-- panel end -->
                                            </div> <!-- col end -->
											</a>	
												
										<a href="./socials" id="socials">
                                          <div class="col-xs-6 col-sm-6 col-md-3">
                                                <div class="panel panel-default">
                                                    <div class="panel-body panel-body-top-br" style="background-color:#FFC300;">
                                                        <div class="stat">
                                                            <h3 class="stat-value">Socials</h3>
                                                        </div>
                                                    </div> <!-- panel body end -->
													<div class="panel-body panel-body-top-br" style="background-color:#FFC300;"></div> <!-- panel body end -->
                                                </div> <!-- panel end -->
                                            </div> <!-- col end -->
											</a>
                                            
											<a href="./accomodation" id="accomodations">
											<div class="col-xs-6 col-sm-6 col-md-3">
                                                <div class="panel panel-default">
                                                    <div class="panel-body panel-body-top-br" style="background-color:#FFC300;">
                                                        <div class="stat">
                                                            <h3 class="stat-value">accomodations</h3>
                                                        </div>
                                                    </div> <!-- panel body end -->
													<div class="panel-body panel-body-top-br" style="background-color:#FFC300;"></div> <!-- panel body end -->
                                                </div> <!-- panel end -->
                                            </div> <!-- col end -->
											</a>
												
											<a href="./disapprove" id="disapprove_challan">
											<div class="col-xs-6 col-sm-6 col-md-3">
                                                <div class="panel panel-default">
                                                
													<div class="panel-body panel-body-top-br" style="background-color:#FFC300;">
                                                        <div class="stat">
                                                            <h3 class="stat-value">Disapprove Challan</h3>
                                                        </div>
                                                    </div> <!-- panel body end -->
													 
                                                </div> <!-- panel end -->
                                            </div> <!-- col end -->
    										
                                            </div> <!-- col end -->
											

									</div> <!-- row end -->

                                        

                                        
                                    </div>
                                    <!-- section container start -->
                                </section>
                                <!-- Section 2 end -->
                            </div>
                            <!-- Main content end -->
                        </div>
                        <!-- Main content wrapper end -->
                    </div>
                    <!-- Side menu + Content end -->
                </div>
            </div>
        </div>
        <!-- Content container end -->
        <!-- Footer container start -->
                <!-- Footer container end -->            
        <!-- ===== PAGE END ===== -->

        <!-- ===== JAVASCRIPT START ===== -->
        <!-- jQuery script -->
        <script src="/js/lib/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
        
        <!-- Bootstrap script -->
        <script src="/js/lib/bootstrap/bootstrap.min.js" type="text/javascript"></script>
        <!-- Theme script -->
        <script src="/js/scripts.js" type="text/javascript"></script>
        <!-- Page specific script -->
        <script type="text/javascript" src="/js/pages/index_1.js"></script>
        <!-- ===== JAVASCRIPT END ===== -->
    </body>
</html>