<?php 
require_once '../bootstrap.php';
$auth->logout();
\App\redirect('/login');
?>