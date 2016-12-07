<?php 
namespace Dashboard;

use Model\Model\SportsQuery;
require(__DIR__ . '/../../bootstrap.php');
//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();

$sports = SportsQuery::create()->find();
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$ids = $_POST['team_member_ids'];

	foreach(array_count_values($ids) as $dupids){
		if ($dupids != 1){
			$errors['duplicates'] = "You've selected one team member more than once!";
		}
	}
	$teamname = trim(strip_tags($_POST['teamname']??''));
	if(str_len($teamname)<5 || strlen($teamname)>50)
		$errors['teamname'] = "Team name too long or too short!";
	if(isset($_POST['sport']))
		$sport = $_POST['sport'];
	else
		$errors['sport'] = "Please select a sport";
	if(!count($errors)){
		// validate that the sport is a valid sport
		$stmt = "select * from sports where SportID = ?";
		$stmt->bind_param($sport);
		$stmt->execute();
		if(!mysql_num_rows($stmt->get_result()))
			$errors['sport'] = "Sport selected is not valid!";
		$stmt->close();

		//validate the each member has already not participated in that sport already
		$in = join(',', array_fill(0, count($ids), '?'));
		$stmt = " select * from sportsteam where SportID = ? AND TeamID IN (SELECT TeamID from sportsparticipant as sp inner join participants as p on p.CNIC = sp.ParticipantCNIC where p.ParticipantID in $in)";
		$stmt->bind_param( str_repeat('i', count($ids)) . "i", $sport, ...$ids);
		$stmt->execute();
		if(mysql_num_rows($stmt->get_result()))
			$errors['team_members'] = "One or more of your team members are already enrolled in this sport!";


		// populate the challan table
		$duedate = "12-10-17";
		$AmountPayable = 400;
		//find the new team ID first
		$teamID = $stmt->get_result()->fetch_all()[0][0];
		$challanID = "S".$teamID."e".$sport;
		$stmt = $conn->prepare("insert into challan(ChallanID, AmountPayable, DueDate, PaymentStatus) values(?,?,?,0)");
		$stmt->bind_param("sis",$challanID, $AmountPayable, $duedate);
		$stmt->execute();		
		$stmt->close();
		//populate the team table
		$stmt = $conn->prepare("insert into sportsteam(TeamID, SportID, TeamName, HeadCNIC, ChallanID, AmountPayable, DueDate, PaymentStatus)) values(?,?,?,?,?,?,?,0)");
		$HeadCNIC = $auth->getCNIC();
		$stmt->bind_param("sssssis", $teamID, $sport, $teamname, $HeadCNIC, $challanID, $AmountPayable, $duedate);
		$stmt->execute();
		$stmt->close();

		//
		//populat the sportsparticipant table
		$stmt = $conn->prepare("insert into sportsparticipant(TeamID, ParticipantID) values(?,?)");
		foreach($ids as $id){
			$stmt->bind_param("ss", $teamID, $id);
			$stmt->execute();
		}
		
	}

	




}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Make a team</title>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	
<?php if( $formsubmitted && count($errors) ): ?>
	<div class="alert-danger">
		<ul class="list-group">
		<?php foreach($errors as $field => $error): ?>
			<li class="list-group-item"><?=$error ?></li>
		<?php endforeach ?>
		</ul>
	</div>
<?php endif ?>
<h2>Make a new team</h2>

<form method="POST">

	<?php foreach($sports as $sport): ?>
	<div>
		<label>
			<input type="radio" value="<?=$sport->getSportID() ?>" name="sport">
			<?=$sport->getName() ?>
		</label>
	</div>
	<?php endforeach ?>
	<div>
		<label>
		Add a team member:
		<input type="text" placeholder="User ID" id="SearchTeamId">
		</label>
		<button id="SearchBtn">Search</button>
	</div>
	<h3>Members added:</h3>
	<div>
		<?=$auth->User()->getUsername() ?>
		<input type="hidden" value="<?=$auth->getParticipant()->getParticipantID()?>" name="team_member_ids[]">
	</div>
	<div id="members"></div>
	<hr>
	<button type="submit">Send</button>
</form>
</div>


<script type="text/javascript" src="..\..\js\jquery.min.js">
</script>
<script type="text/javascript">
$(function(){
	$("#SearchBtn").click(function(e){
		console.log($("#SearchTeamId").val());
		var destination="/dashboard/search.php";
		$.post(destination, {'id' : $("#SearchTeamId").val()}, function(result){
  				if(result){
  					$result = JSON.parse(result);
  					console.log($result);
  					$newelement = "<div class='member'><h3>";
  					$newelement += $result.Firstname + " " + $result.Lastname;
  					$newelement += "</h3>";
  					$newelement += "<input type='hidden' name='team_member_ids[]' value='"+$result.Participantid+"' >";
  					$newelement += "</div>";
  					$("#members").append($newelement);
  					console.log($newelement);
  				}
  			}
		);
		e.preventDefault();
	});


});
</script>
</body>	

</html>