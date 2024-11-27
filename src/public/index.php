<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER ['REQUEST_METHOD'];

if($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_login.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} elseif($requestUri === '/registration') {
    if ($requestMethod === 'GET') {
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_registration.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} elseif ($requestUri === '/catalog') {
    if ($requestMethod === 'GET') {
        require_once './catalog.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}elseif ($requestUri === '/add-product') {
    if ($requestMethod === 'GET') {
        require_once './get_add_product.php';
    } elseif ($requestMethod === 'POST') {
        require_once './handle_add_product.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}elseif ($requestUri === '/logout') {
    if ($requestMethod === 'GET') {
        require_once './logout.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}elseif ($requestUri === '/basket') {
    if ($requestMethod === 'GET') {
        require_once './basket.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
}

else {
    http_response_code(404);
    require_once './404.php';
}




