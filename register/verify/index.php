<?php
require_once(__DIR__."/../../bootstrap.php");
function sanitize($data){
    return htmlspecialchars(strip_tags($data));
}

if( isset($_GET['username']) && isset($_GET['activationcode']) ){
	$error = false;
	$URLusername = sanitize($_GET["username"]);
	$URLcode = sanitize($_GET["activationcode"]);
	$stmt = $mpdo->prepare("SELECT ActivationCode FROM useraccount WHERE Username = ?") ;
	$stmt->execute([$URLusername]);
	if($stmt->rowCount() < 0) {
		$error = true;
	}
	else{
		$row=$stmt->fetch(PDO::FETCH_NUM);
		if($row[0] == $URLcode){
			$stmt = $mpdo->prepare("UPDATE useraccount SET AccountStatus=1 WHERE Username =?");
			$stmt->execute([$URLusername]);
		}
		else{
			$error = true;
		}
	}

	if(!$error){
		\App\redirect("/login");
	}
}
else{
	$error = true;	
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Nust Olympiad'17</title>
</head>
<body>
	<h2>404 - Invalid Link!</h2>
</body>
</html>