<?php 
require("bootstrap.php");
$auth->onlyLoggedIn();
var_dump(\Dashboard\getChallans($auth, $conn));