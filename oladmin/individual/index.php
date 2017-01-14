<?php 
require(__DIR__."/../bootstrap.php");
$auth->onlyAdmin();
$errors = [];
$success = false;
if($formsubmitted){
    $challanid = trim($_POST['challanid'] ?? '');
    $approve = trim($_POST['approve'] ?? "");
    if(strlen($challanid)){
        $stmt = $mpdo->prepare("select * from challan as c inner join eventparticipants as ep on c.ChallanID = ep.ChallanID inner join participant as p on ep.ParticipantCNIC = p.Cnic inner join events on events.EventID = ep.EventID where ep.ChallanID = ? and events.EventType = 2");
        $stmt->execute([$challanid]);
        if(!$stmt->rowCount()){
            $errors[] = "Wrong Individual Challan ID.";
        }
        else{
            $challan = ($stmt->fetchAll(PDO::FETCH_OBJ)[0]);
        }
    }
    elseif( strlen($approve) ){

        $stmt = $mpdo->prepare("update challan set PaymentStatus = 1 where ChallanID = ?");

        $stmt->execute([$approve]);
        if(!$stmt->rowCount()){
            $errors[] = "Some error occured!";
        }
        else{
            $success = 1;
        }
    }
    else
        $errors[] = "Please enter a challan id to search";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Individual Challan </title>

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
                    <div class="navbar-header">
                    
                    </div>
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
                                    <ul class="nav nav-pills nav-stacked custom-nav">
                                        
                                        <li class="nav-header">Menu</li>
                                        
                                        
                                        <li class=" nav-active current"><a href="/oladmin/registration"><i class="ion ion-laptop"></i> <span>Registration Challan</span></a>
                                           
                                        </li>
										
										
										  <li class="  nav-active current"><a href="/oladmin/teams"><i class="ion ion-laptop"></i> <span>Team Challan</span> 
                                        </li></a>
										
										  <li class=" nav-active current"><a href="#"><i class="ion ion-laptop"></i> <span>Individual Challan</span></a>
                                        </li>
										
										  <li class=" nav-active current"><a href="/oladmin/socials"><i class="ion ion-laptop"></i> <span>Socials</span></a>
                                        </li>
										
										  <li class=" nav-active current"><a href="/oladmin/accomodation"><i class="ion ion-laptop"></i> <span>Accomodation Challan</span></a>
                                        </li>
										
										
										  <li class=" nav-active current"><a href="/oladmin/disapprove"><i class="ion ion-laptop"></i> <span>Disapprove Challan</span></a>
                                        </li>
										
                                    </ul>
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
                <ol class="breadcrumb">
                    <li><a href="/oladmin">Home</a></li>
                    
                </ol>
</div>
        </div>
    </div>
    <!-- Main content start -->
    <div class="main-content">
        <!-- Section start -->
        <section>
            <!-- title container start -->
            <div class="container-fluid container-padded">
                <div class="row">
                        <div class="col-md-12 page-title">
                        <h2>Individual Challan</h2>
                        <hr>
                    </div> <!-- col end -->
                </div> <!-- row end -->
            </div>
			<div class="row">
				<div class="col-md-12">
                 	<div class="panel-body col-md-12">
                        <?php if(count($errors)): ?>
                        <div class="alert alert-danger">
                            <?php foreach($errors as $error): ?>
                            <div class="row">
                                <?= $error ?>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <?php endif ?>
                        <?php if($success): ?>
                        <div class="alert alert-success">
                            Challan has been approved!
                        </div>
                        <?php endif ?>
						<form class="form-inline" role="form" method="POST">
							<div class="form-group col-xs-10">
								<input type="text" style="width:100%;" name="challanid" class="form-control inputlg"  placeholder="Search">
							</div>
							<div class=" col-md-2">
					<button type="submit" class="btn btn-primary">Search</button>							
							</div>
					   
                                </form>
                            </div> <!-- panel body end -->
                        </div> <!-- panel end -->
                    </div> <!-- col end -->
			</div>
            <!-- title container end -->
            
            <!-- section container start -->
            <div class="container-fluid container-padded">
                <div class="row">
                    <div class="col-md-12">
                        
						<?php if(isset($challan)): ?>
                        <table class="table">
                            <thead>
                                <th>Participant Name</th>
                                <th>Amount Payyable</th>
                                <th>DueDate</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=$challan->Name?></td>
                                    <td><?=$challan->AmountPayable?></td>
                                    <td><?=$challan->DueDate?></td>
                                    <td>
                                        <?php if($challan->PaymentStatus): ?>
                                            <button disabled class="btn btn-primary">Already Approved!</button>
                                        <?php else: ?>
                                            <form method="POST">
                                                <input type="hidden" name="approve" value="<?=$challanid?>">
                                                <button type="submit" class="btn btn-primary">Approve</button>
                                            </form>
                                        <?php endif ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <?php endif ?>
						
						
                    </div> <!-- col end -->
                </div> <!-- row end -->
            </div>
            <!-- section container end -->
        </section>
        <!-- Section end -->
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
        
        <!-- ===== JAVASCRIPT START ===== -->
        <!-- jQuery script -->
        <script src="/js/jquery-1.10.2.min.js" type="text/javascript"></script>
        <!-- Bootstrap script -->
        <script src="/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Theme script -->
        <script src="js/scripts.js" type="text/javascript"></script>
        
        <!-- Page specific script -->
                        <!-- ===== JAVASCRIPT END ===== -->
    </body>
</html>