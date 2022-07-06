<?php

require_once 'vendor/autoload.php';

use Source\App\PVE;

$pxmx = (new PVE())->get('/nodes/0/');

var_dump($pxmx);