<?php 
require_once(__DIR__."/../bootstrap.php");

$auth->logout();
\App\redirect("/oladmin/login");
?>