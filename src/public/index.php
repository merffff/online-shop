<?php

use Core\App;

//$autoloadCore = function (string $className) {
//    $path = "./../Core/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//
//$autoloadController = function (string $className) {
//    $path = "./../Controller/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//
//$autoloadModel = function (string $className) {
//    $path = "./../model/$className.php";
//    if (file_exists($path)) {
//        require_once $path;
//        return true;
//    }
//    return false;
//};
//
//spl_autoload_register($autoloadCore);
//spl_autoload_register($autoloadController);
//spl_autoload_register($autoloadModel);

$autoload =  function ($className) {
    $handlerPath = str_replace('\\','/', $className);
    $path = "./../$handlerPath.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};

spl_autoload_register($autoload);



$app = new App();
$app->run();
