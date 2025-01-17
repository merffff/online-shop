<?php
require_once './../Core/Autoload.php';

use Core\App;
use Core\Autoload;

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


Autoload::registrate(dirname(__DIR__));




$app = new App();
$app->run();
