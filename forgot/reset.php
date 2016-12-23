<?php 
require_once(__DIR__."/../bootstrap.php");

//three posibilities: 1- link is invalid 2- link is valid: show email and password form 3- link is valid and the token and password is sent as POST request

$token = ($_GET['token']) ? $_GET['token'] : "";
$invalid = false;
if(strlen(trim($token))){
	$stmt = $mpdo->prepare("select * from useraccount where ResetCode = ?");
	$stmt->execute([$token]);
	if(!$stmt->rowCount()){
		$invalid = true;
	}

	if(!isset($error)){
		$user = $stmt->fetch();
		//here change the password
	}
}
else{
	$invalid = true;
}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Reset Password | Olympiad'17</title>
</head>
<body>
<?php 
//if the link is invalid, then the invalid variable is set, otherwise it is not
//so only display form is the invalid is false
if(!$invalid):
?>
<form method="POST">
	<input type="hidden" name="token" value="<?=$token?>">
	<label>
		Email:
		<input type="email" name="email">
	</label>
	<label>
		Password
		<input type="password" name="pwd">
	</label>
	<label>
		Confirm Password
		<input type="password" name="repwd">
	</label>
	<input type="submit" value="Reset">
</form>
<?php else: ?>
<h3>Invalid Link!</h3>
<?php endif ?>
</body>
</html>