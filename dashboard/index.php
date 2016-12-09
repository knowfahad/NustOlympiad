<?php 
namespace Dashboard;
require(__DIR__ . '/../bootstrap.php');
//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();
$challans = \Dashboard\getChallans($auth, $mpdo);
$accomodationChallan = accomodationChallan($auth, $mpdo);
$registrationChallan = registrationChallan($auth, $mpdo);
$teams = enrolledTeams($auth, $mpdo);
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
	<li class="list-group-item"><a href="/dashboard/teams">Make a team</a></li>

</ul>
<!---list-group-item-warning-->
<h3>Challans</h3>
<ul class="list-group">
	<?php if($accomodationChallan): ?>
	<li class="list-group-item <?=($accomodationChallan['PaymentStatus'])?"list-group-item-success":"list-group-item-danger" ?>">
		<h4>Accomodation Challan</h4>
		<?php if(!$accomodationChallan['PaymentStatus']): ?>
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
		<?php endif ?>
	</li>
	<?php endif ?>

	<?php if($registrationChallan): ?>
	<li class="list-group-item <?=($registrationChallan['PaymentStatus'])?"list-group-item-success":"list-group-item-danger" ?>">
		<h4>Registration Challan</h4>
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
	</li>
	<?php endif ?>
<?php foreach($challans as $challan): ?>
	<li class="list-group-item <?=($challan['PaymentStatus'])?"list-group-item-success":"list-group-item-danger" ?>">
		<h4><?=$challan['Name']?></h4>
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

	</li>
<?php endforeach ?>

<?php if(count($teams)): ?>
<?php foreach($teams as $team): ?>
	<?php $challan = $team->challan() ?>
	<li class="list-group-item 
	<?=($challan['PaymentStatus'])?"list-group-item-success":"list-group-item-danger" ?>">
		<h4><?=$team->TeamName?></h4>
		<?php if(!$challan['PaymentStatus']): ?>
		<form method="POST" action="http://ol-challan-generator.herokuapp.com/">
			<input type="hidden" value="Sports team: <?=$team->TeamName?>" name="eventname">
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

	</li>

<?php endforeach ?>
<?php endif ?>
</ul>

<?php if(count($teams)): ?>
<h3>Teams</h3>
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

</body>
</html>