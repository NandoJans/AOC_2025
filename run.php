<?php

require_once __DIR__.'/vendor/autoload.php';
use core\Application;
use core\Autowire;


const __ROOT__ = __DIR__;


$app = Autowire::start(Application::class);
$app->run();