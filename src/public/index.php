<?php
require_once './../Core/Autoload.php';

use Core\App;
use Core\Autoload;
use Controller\UserController;
use Controller\ProductController;
use Controller\BasketController;
use Controller\OrderController;

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
$app->addRoute('/registration', 'GET', UserController::class, 'getRegistrateForm');
$app->addRoute('/registration', 'POST', UserController::class, 'Registrate');
$app->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$app->addRoute('/login', 'POST', UserController::class, 'login');
$app->addRoute('/catalog', 'GET', ProductController::class, 'getCatalog');
$app->addRoute('/add-product', 'GET', BasketController::class, 'getAddProduct');
$app->addRoute('/add-product', 'POST', BasketController::class, 'addProduct');
$app->addRoute('/logout', 'GET', UserController::class, 'logout');
$app->addRoute('/basket', 'GET', BasketController::class, 'getBasket');
$app->addRoute('/order', 'GET', OrderController::class, 'getOrder');
$app->addRoute('/order', 'POST', OrderController::class, 'handleOrder');
$app->addRoute('/completedOrder', 'GET', OrderController::class, 'completedOrder');
$app->addRoute('/orders', 'GET', OrderController::class, 'getOrders');

$app->run();
