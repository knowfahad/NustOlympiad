<?php 

require 'app/bootstrap.php';
$capture = new \codeCourse\capture\capture;
$view = new \codeCourse\Views\View;

$capture->load('invoice.php',[
	'order' => '123455',
	'name' => 'Wali',
	'amount' => 234.33,
]);
$capture->respond('invoice.pdf');