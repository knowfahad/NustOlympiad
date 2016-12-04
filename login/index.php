<?php 
require_once('../bootstrap.php');

if($auth->loggedIn()){
	\App\redirect("/dashboard");
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	//form was submitted
	$username = strip_tags(strtolower(trim($_POST['username'] ?? '')));
	$password = strip_tags($_POST['password']??'');
	if(!strlen($username) || !strlen($password))
		$error = "Please enter username and password!";
	else{
		if($auth->login($_POST['username'], $_POST['password'])){
			\App\redirect('/dashboard');
		}
		else{
			$error = "Username and password didn't match!";
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login | NUST Olympiad '17</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
	<h2>Login</h2>
	<?php if(isset($error)): ?>
	<div class="alert-danger">
		<?=$error?>
	</div>
	<?php endif ?>
	<form method="POST">
		<div class="form-group">
		    <label for="" class="col-md-4 control-label">Username</label>
		
		    <div class="col-md-6">
		        <input type="text" value="<?= $_POST['username']??'' ?>" class="form-control" name="username">
		    </div>
		</div>
		<div class="form-group">
		    <label for="" class="col-md-4 control-label">Password</label>
		
		    <div class="col-md-6">
		        <input type="password" class="form-control" name="password">
		    </div>
		</div>
		<button type="submit">Login</button>

	</form>
</div>
</body>
</html>