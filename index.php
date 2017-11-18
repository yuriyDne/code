<?php
require_once __DIR__ . '/autoload.php';

$errorLevel = \config\Constants::DEBUG_MODE ? E_ALL : 0;
error_reporting($errorLevel);
ini_set('display_errors', '1');
date_default_timezone_set("UTC");
session_start();

$app = new \lib\WebApplication();
$app->run();