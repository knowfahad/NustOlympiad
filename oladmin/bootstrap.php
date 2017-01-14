<?php 
ini_set('display_errors', '1');
error_reporting(E_ALL);
use OlAdmin\Auth;
if(!isset($_SESSION)) 
{ 
    session_start(); 
}
require (__DIR__ . '/../vendor/autoload.php');
require (__DIR__ . '/../generated-conf/config.php');
require (__DIR__.'/../OlAssets/dbconnect.php');


$auth = new Auth($mpdo);

$formsubmitted = $_SERVER['REQUEST_METHOD'] == 'POST';
?>