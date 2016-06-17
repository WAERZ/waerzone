<?php
define('DEBUG', true);
define('ROOT', dirname(__FILE__).'/');
define('CORE', ROOT.'core/');
define('APP', ROOT.'app/');
define('VIEW', APP.'view/');
if (DEBUG){
    ini_set('display_errors', 1);
    error_reporting (E_ALL);
    $time = microtime();
}

session_start();

require_once(CORE.'autoload.php');

$route = new Router();
$route->init();

if (DEBUG) {
    $template = View::init();
    $template->set('footer', '<hr>This page generate = ' . (int) ((microtime() - $time) * 1000) . ' ms');
}