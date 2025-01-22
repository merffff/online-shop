<?php
require_once './../Core/Autoload.php';

use Core\App;
use Core\Autoload;
use Controller\UserController;
use Controller\ProductController;
use Controller\BasketController;
use Controller\OrderController;
use Request\RegistrateRequest;
use Request\LoginRequest;
use Request\BasketRequest;
use Request\OrderRequest;

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
$app->addGetRoute('/registration', UserController::class, 'getRegistrateForm');
$app->addPostRoute('/registration', UserController::class, 'Registrate', RegistrateRequest::class);
$app->addGetRoute('/login', UserController::class, 'getLoginForm');
$app->addPostRoute('/login', UserController::class, 'login', LoginRequest::class);
$app->addGetRoute('/catalog', ProductController::class, 'getCatalog');
$app->addGetRoute('/add-product', BasketController::class, 'getAddProduct');
$app->addPostRoute('/add-product', BasketController::class, 'addProduct', BasketRequest::class);
$app->addGetRoute('/logout', UserController::class, 'logout');
$app->addGetRoute('/basket', BasketController::class, 'getBasket');
$app->addGetRoute('/order', OrderController::class, 'getOrder');
$app->addPostRoute('/order', OrderController::class, 'handleOrder',OrderRequest::class);
$app->addGetRoute('/completedOrder', OrderController::class, 'completedOrder');
$app->addGetRoute('/orders', OrderController::class, 'getOrders');

$app->run();
