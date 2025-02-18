<?php
require_once './../Core/Autoload.php';

use Controller\BasketController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Core\App;
use Core\Autoload;
use Request\BasketRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Request\ReviewRequest;

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


$loggerService = new \Service\Logger\LoggerFileService();
$container = new \Core\Container();

$container->set(BasketController::class, function (\Core\Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $productService = new \Service\BasketProductService();
    return new BasketController($authService, $productService);
});

$container->set(OrderController::class, function (\Core\Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $productService = new \Service\BasketProductService();
    $orderService = new \Service\OrderService();
    return new OrderController(
        $authService,
        $productService,
        $orderService,
       );
});

$container->set(ProductController::class, function (\Core\Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    return new ProductController($authService);
});

$container->set(UserController::class, function (\Core\Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    return new UserController($authService);
});

$container->set(\Service\Auth\AuthServiceInterface::class, function () {
    return new \Service\Auth\AuthSessionService();
});

$container->set(\Service\Logger\LoggerServiceInterface::class, function () {
    return new \Service\Logger\LoggerFileService();
});




$app = new App($loggerService, $container);
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
$app->addPostRoute('/product', ProductController::class, 'getProduct',  \Request\ProductRequest::class);
$app->addPostRoute('/review', ProductController::class, 'handleReview', ReviewRequest::class);
$app->addPostRoute('/addProduct', BasketController::class, 'addProducts', BasketRequest::class);
$app->addPostRoute('/deleteProduct', BasketController::class, 'deleteProducts', BasketRequest::class);

$app->run();
