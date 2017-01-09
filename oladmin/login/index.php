<?php 
require_once(__DIR__."/../bootstrap.php");
$auth->onlyNotAdmin();
if($formsubmitted){
  if($auth->login($_POST['username'], $_POST['password'])){
    \App\redirect("/oladmin/");
  }
  else{
    $error = "Username and password didn't match!";
  
  }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>OlAdmin</title>
  <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <h2>Admin Panel</h2>
  <div class="panel panel-default">
	<div class="panel-heading">Admin Login</div>
    <div class="panel-body">
    	<form method="POST">
      <?php if(isset($error)):?>
      <div class="alert alert-danger">
        <?=$error?>
      </div>
      <?php endif ?>
    		<div class="form-group">
    			<label for="username" class="control-label">Username</label>
				<input type="text" name="username" class="form-control">
    		</div>
    		<div class="form-group">
    			<label for="password" class="control-label">password</label>
				<input type="password" name="password" class="form-control">
    		</div>
        <button type="submit">Sign In</button>
    	</form>
    </div>

  </div>
</div>
</body>
</html>