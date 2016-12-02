<?php 
namespace Dashboard;
require(__DIR__ . '/../bootstrap.php');

//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn()

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard | NUST Olymiad '17</title>
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

<ul class="list-group">
	<li class="list-group-item"><a href="/dashboard/accomodation">Accomodation</a></li>
	<li class="list-group-item"><a href="/dashboard/individual">Individual events</a></li>
	<li class="list-group-item"><a href="/dashboard/social">Social events</a></li>
</ul>


</body>
</html>