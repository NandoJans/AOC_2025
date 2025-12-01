<?php

require_once __DIR__.'/vendor/autoload.php';
use core\Application;


const __ROOT__ = __DIR__;


$app = new Application();
$app->run();