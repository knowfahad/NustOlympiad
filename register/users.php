<?php
namespace Register;
require_once("../vendor/autoload.php");
require_once("../generated-conf/config.php");

use Model\Model\ParticipantQuery;

$suchal = ( new ParticipantQuery)->findPK(1478);
echo $suchal->getCnic();
