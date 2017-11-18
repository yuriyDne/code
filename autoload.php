<?php
define('DS', DIRECTORY_SEPARATOR);
$siteRoot = realpath(dirname(__FILE__)) . DS;
define('SITE_ROOT', $siteRoot);
define('MVC_PATH', SITE_ROOT . 'mvc' . DS);
define('CONTROLLER_PATH', MVC_PATH . 'controllers'. DS);

require_once "vendor/autoload.php";

$autoloadFunction = function($className) {
    $availableFileLocations = [
        SITE_ROOT,
        MVC_PATH,
        MVC_PATH. 'Module'.DS,
    ];
    static $loadedClasses = [];

    $isFleFounded = false;
    foreach ($availableFileLocations as $fileLocation) {
        $filePath = $fileLocation . str_replace('\\', '/', $className) . '.php';
        if (file_exists($filePath)) {
            if (!isset($loadedClasses[$className])) {
                $loadedClasses[$className] = $filePath;
                include $filePath;
            }
            $isFleFounded = true;
            break;
        }
    }

    if (!$isFleFounded) {
        throw new \RuntimeException("Cannot find file $className by path $filePath");
    }
};

spl_autoload_register($autoloadFunction);
