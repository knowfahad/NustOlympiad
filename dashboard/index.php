<?php 
namespace Dashboard;

use Model\Model\SportsQuery;
require(__DIR__ . '/../../bootstrap.php');
//blocks users who are not logged in from visiting this page
$auth->onlyLoggedIn();

$sports = SportsQuery::create()->find();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Make a team</title>
</head>
<body>
<h2>Make a new team</h2>
<form>
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
	<div>
		<!--list the team members here
		like a hidden input 
		<div>
			Name of the team member
			<input type="hidden" name="team_member_ids[]">
		</div>
		send the userid to /dashboard/search.php
		returns empty json if no user found
		example of a valid response:
		{
		  "Participantid": 1487,
		  "Cnic": "3120278943379",
		  "Registrationchallanid": "RC10",
		  "Accomodationchallanid": "AC1487g",
		  "Firstname": "suchal",
		  "Lastname": "riaz",
		  "Gender": "M",
		  "Address": "LOrem Ipsum ...",
		  "Phoneno": "03030766865",
		  "Nustregno": null,
		  "Ambassadorid": null
		}
		-->

	</div>
	<hr>
	<button type="submit">Send</button>
</form>
<div class="hidden">
			Name of the team member
</div>
<script type="text/javascript" src="..\..\js\jquery.min.js">
</script>
<script type="text/javascript">
$(function(){
	$("#SearchBtn").click(function(e){

		var destination="../search.php";
		$.ajax({                    
  			url: destination,     
  			Type: 'post', // performing a POST request
  			contentType: "application/json",
  			
  			data : {
    			'id' : $("#SearchTeamId").val() // will be accessible in $_POST['data1']
  			},
  			                   
  			success: function(data)         

  			{
  				if(data){


  					$(".hidden").append("<input type=hidden name=team_member_ids[] id=hide"+data['Participantid']+"value="+data['Participantid']+">")
  					
  				}
  				else{
  				}

  			} 
  			
});

		e.preventDefault();
	})


})
</script>
</body>	

</html>