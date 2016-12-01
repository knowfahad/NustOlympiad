<?php
namespace App;
require_once(__DIR__.'/../bootstrap.php');
function redirect($url) {
    ob_start();
    header('Location: '.$url);
    ob_end_flush();
    die();
}
