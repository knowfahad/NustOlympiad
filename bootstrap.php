<?php 
ini_set('display_errors', '1');
error_reporting(E_ALL);
use App\Auth;
session_start();
require_once (__DIR__ . '/vendor/autoload.php');
require_once (__DIR__ . '/generated-conf/config.php');
require_once (__DIR__ . '/dbconf.php');
require_once (__DIR__.'/OlAssets/dbconnect.php');
$mpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $mpdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$auth = new Auth();

?>