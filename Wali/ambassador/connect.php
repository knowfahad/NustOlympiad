<?php
	$host = "localhost";

$user = "root";
$pass = "";
$db = "olympiad";
	$conn = mysqli_connect($host,$user,$pass,$db);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }else{
	
}
?>