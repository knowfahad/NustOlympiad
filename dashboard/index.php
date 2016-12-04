<?php 
namespace Dashboard;
require(__DIR__ . '/../bootstrap.php');

//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();
$challans = \Dashboard\getChallans($auth, $conn);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | NUST Olymiad '17</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
</head>
<body>
<?php if(!$auth->User()->isVerified()): ?>
<div class="alert-warning">
	Please verify your email to continue the registration!
</div>
<?php endif ?>


<h1>Welcome, <?= $auth->user()->getUsername() ?></h1>
<h3>Your UserID is <?=$auth->getParticipant()->getParticipantID() ?></h3>
<ul class="list-group">
	<li class="list-group-item"><a href="/dashboard/accomodation">Accomodation</a></li>
	<li class="list-group-item"><a href="/dashboard/individual">Individual events</a></li>
	<li class="list-group-item"><a href="/dashboard/social">Social events</a></li>
</ul>
<!---list-group-item-warning-->
<h3>Challans</h3>
<ul class="list-group">

<?php foreach($challans as $challan): ?>
	<li class="list-group-item <?=($challan['PaymentStatus'])?"list-group-item-success":"list-group-item-danger" ?>">
		<h4><?=$challan['Name']?></h4>
		<?php if(!$challan['PaymentStatus']): ?>
		<form method="POST" action="http://pdf.app">
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

	</li>
<?php endforeach ?>
</ul>


</body>
</html>