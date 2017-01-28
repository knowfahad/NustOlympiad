<?php 
require("bootstrap.php");
if(isset($_FILES['file'])){
	$info = pathinfo($_FILES['file']['name']);
	var_dump($info);
	var_dump($_FILES['file']);
	echo "size is " . $_FILES['file']['size']/1048576;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form enctype="multipart/form-data" method="POST">
	<input type="file" name="file">
	<input type="submit" name="submit" value="submit">
</form>
</body>
</html>
