<?php

namespace Core;


use Controller\BasketController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

class App
{

    private array $routes = [];
    public function run(): void
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER ['REQUEST_METHOD'];

        if (array_key_exists($requestUri, $this->routes)){
            if (array_key_exists($requestMethod, $this->routes[$requestUri])){
                foreach ($this->routes[$requestUri][$requestMethod] as $key =>$methodRoute){
                    if ($key === 'class') {
                        $obj = new $methodRoute();
                    } elseif ($key === 'method') {
                        $obj->$methodRoute();
                    }
                }
            }else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } else {
            http_response_code(404);
            require_once './../view/404.php';
        }


    }

    public function addRoute(string $uriName, string $uriMethod, string $className, string $method): void
    {
        if(!isset($this->routes[$uriName][$uriMethod])) {
            $this->routes[$uriName][$uriMethod]['class'] = $className;
            $this->routes[$uriName][$uriMethod]['method'] = $method;
        } else {
            echo "$uriMethod уже зарегистрирован для $uriName" . "<br>";
        }
    }

}