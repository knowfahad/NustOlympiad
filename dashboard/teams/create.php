<?php 
namespace Dashboard;
require(__DIR__ . '/../../bootstrap.php');

use PDO;
use Model\Model\SportsQuery;
use Respect\Validation\Validator as v;

function sanitize($data){
    return htmlspecialchars(strip_tags($data));
}


$sports = SportsQuery::create()->find();
$formsubmitted = $_SERVER['REQUEST_METHOD'] == "POST"; 
if($formsubmitted){
    $errors = [];
    $ids = $_POST['team_member_ids'] ?? [];
    if(!count($ids)){
        $errors["ids"] = "You didn't add any members to the team!";
    }
    else{
    	//every member must be unique    
        foreach(array_count_values($ids) as $dupids){
            if ($dupids != 1){
                $errors['duplicates'] = "You've selected one team member more than once!";
            }
        }
    }


    $teamname = trim(sanitize($_POST['teamname']??''));
    $teamnamevalidation = v::NotEmpty()->NoWhitespace()->alnum()->length(3,20);
    if(!$teamnamevalidation->validate($teamname))
        $errors['teamname'] = "Please enter a valid team name.";
    if(isset($_POST['sport']))
        $sport = sanitize($_POST['sport']);
    else
        $errors['sport'] = "Please select a sport";

    
    if(!count($errors)){
        // validate that the sport is a valid sport
        $stmt = $mpdo->prepare("select * from sports where SportID = ?");
        $stmt->execute([$sport]);
        if(!$stmt->rowCount())
            $errors['sport'] = "Sport selected is not valid!";
        else{
            $sport = $stmt->fetch(PDO::FETCH_OBJ);
            $stmt = $mpdo->prepare("select * from sportsteam where TeamName = ? AND SportID = ?");
            $stmt->execute([$teamname, $sport->SportID]);
            if($stmt->rowCount()){
                $errors['teamname'] = "The team name has already been reserved!";
            }
        }
        if(isset($_POST['ambassador_id']) && strlen(trim($_POST['ambassador_id']))){
            $stmt = $mpdo->prepare("select * from ambassador where AmbassadorID = ?");
            $stmt->execute([$_POST['ambassador_id']]);
            if(!$stmt->rowCount()){
                $errors["ambassador_id"] = "The ambassador id you entered is incorrect.";
            }
            else{
                $ambassador_id = $_POST['ambassador_id'];
            }
        }

	}
/*//validate the each member has already not participated in that sport already
//      $in = join(',', array_fill(0, count($ids), '?'));
//      if($stmt = $mpdo->prepare(
// <<<participatedquery
// select *
// from sportsteam
// where SportID = ?
// AND TeamID IN (
//  SELECT TeamID
//  from sportsparticipants
//  where ParticipantID in ($in)
// )
// participatedquery
// )){
//      $params = [$sport];
//      $params = array_merge($params, $ids);
//      $stmt->execute( $params);
//      if($stmt->rowCount())
//          $errors['team_members'] = "One or more of your team members are already enrolled in this sport!";
//      }
//      else{
//          die($sth->errorInfo());
//      }*/
	if(!count($errors)){
        $numOfMembers = count($ids);
        // check if the total number of members are within range
        if($numOfMembers < $sport->MinParticipants || $numOfMembers > $sport->MaxParticipants){
        	$errors['NoOfMembers'] = "Number of team members should be between ".$sport->MinParticipants." and " .$sport->MaxParticipants." members";
            if($sport->MinParticipants == $sport->MaxParticipants){
                $errors['NoOfMembers'] = "Number of team members should be exactly ". $sport->MinParticipants;
            }
        }
    }

    if(!count($errors)){
		 
        // populate the challan table
        $duedate = Carbon::today()->addWeeks(2)->toDateString();
        $AmountPayable = $numOfMembers * $sport->FeePerParticipant + $sport->RegistrationFee;
        //find the new team ID first
        $stmt = $mpdo->prepare("select max(TeamID) as max from sportsteam");
        $stmt->execute();
        $teamID = $stmt->fetch();
        if(count($teamID))
            $teamID = $teamID[0]+1;
        if($teamID == 0)
            $teamID = 1752;
        $challanID = "T".$teamID."e".$sport->SportID;
        $stmt = $mpdo->prepare("insert into challan(ChallanID, AmountPayable, DueDate, PaymentStatus) values(?,?,?,0)");
        $stmt->execute([$challanID, $AmountPayable, $duedate]);

        //populate the team table
        $stmt = $mpdo->prepare("insert into sportsteam(TeamID, SportID, TeamName, HeadCNIC, ChallanID, AmountPayable, DueData) values(?,?,?,?,?,?,?)");
        $HeadCNIC = $auth->getCNIC();
        $stmt->execute([$teamID, $sport->SportID, $teamname, $HeadCNIC, $challanID, $AmountPayable, $duedate]);

        //populate the sportsparticipant table
        $stmt = $mpdo->prepare("insert into sportsparticipants(TeamID, ParticipantID) values(?,?)");
        foreach($ids as $id){
            $stmt->execute([$teamID, $id]);
        }
        if(isset($ambassador_id)){
            foreach($ids as $id){
                $stmt = $mpdo->prepare("insert into ambassador_participant(ParticipantID, AmbassadorID, EventID, SportID, ChallanID) values(?,?,?,?,?)");
                $stmt->execute([$id, $ambassador_id, null, $sport->SportID, $challanID]);
            }
        }


    }
}

if(count($errors)){
    echo json_encode($errors);
}
else{
    echo 1;
}
?>