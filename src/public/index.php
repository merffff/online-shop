<?php

require_once './../Controller/UserController.php';
require_once './../Controller/ProductController.php';
require_once './../Controller/BasketController.php';

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER ['REQUEST_METHOD'];

if($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        $userController = new UserController();
        $userController->getLoginForm();
    } elseif ($requestMethod === 'POST') {
        $userController =new UserController();
        $userController->login();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} elseif($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        $userController = new UserController();
        $userController->getRegistrateForm();
    } elseif ($requestMethod === 'POST') {
        $userController = new UserController();
        $userController->registrate();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} elseif ($requestUri === '/catalog') {
    if ($requestMethod === 'GET') {
        $productController = new ProductController();
        $productController->getCatalog();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}elseif ($requestUri === '/add-product') {
    if ($requestMethod === 'GET') {
        $BasketController = new BasketController();
        $BasketController->getAddProduct();
    } elseif ($requestMethod === 'POST') {
        $BasketController = new BasketController();
        $BasketController->addProduct();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}elseif ($requestUri === '/logout') {
    if ($requestMethod === 'GET') {
        $UserController =new UserController();
        $UserController->logout();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}elseif ($requestUri === '/basket') {
    if ($requestMethod === 'GET') {
        $BasketController = new BasketController();
        $BasketController->getBasket();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}

else {
    http_response_code(404);
    require_once './../view/404.php';
}




