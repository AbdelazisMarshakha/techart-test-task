<?php
session_start();
define('ROOT', dirname(__FILE__));



//IS DEBUG OR DEV
define('DEBUG',true);

require_once (ROOT.'/config/settings.php');
$Autoloader = require_once(ROOT.'/components/Autoload.php');

$router = new Router();
$router->run();

