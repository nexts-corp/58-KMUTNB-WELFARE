<?php
date_default_timezone_set('Asia/Bangkok');
require_once "vendor/autoload.php";
require_once "vendor/mustache/mustache/src/Mustache/Autoloader.php";
require_once 'vendor/bpg/cde/lib/core/AutoLoader.php';
require_once 'vendor/phpoffice/tcpdf/tcpdf.php';
use th\co\bpg\cde\core\ChangdaoEngine;
Logger::configure(dirname(__FILE__) . '/log4php.properties');
Mustache_Autoloader::register();
$changdaoEngine = new ChangdaoEngine();
$changdaoEngine->start();
?>