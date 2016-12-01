<?php
namespace Dashboard;

use Model\Model\Challan;
use Model\Model\ChallanQuery;
use Model\Model\ParticipantQuery;
require_once(__DIR__."/../../bootstrap.php");

//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	if(isset($_POST['agree'])){
		$participant = $auth->getParticipant();
		$gender = ($participant->getGender() == "male") ? "m" : "g";
		$challanid = "AC" . $participant->getParticipantID() .  $gender;
		$challan = new Challan();
		$challan->setChallanID($challanid);
		$challan->setAmountPayable(500);
		$challan->setDueDate("10-10-2016");
		$challan->setPaymentStatus(0);
		$challan->save();

		$participant->setAccomodationChallanID($challanid);
		$participant->save();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Accomodation | Nust Olympiad '17</title>
	<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css">
</head>
<body>
	<?php //if($auth->User()->)  ?>
	<div class="container">
		<h2>Apply For accomodation:</h2>
		
		<div>
			<h3>Instruction:</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
			<form method="POST">
				<div class="form-group">
					<button class="btn btn-primary" value="yes" name="agree">I agree</button>
					<a href="/dashboard" class="btn btn-warning">Cancel</a>
				</div>
			</form>
		</div>
	</div>

</body>
</html>