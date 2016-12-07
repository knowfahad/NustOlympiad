<?php 
require("bootstrap.php");

$stmt = $conn->prepare("select max(TeamID) as max from sportsteam");
$stmt->execute();
var_dump($stmt->get_result()->fetch_all());