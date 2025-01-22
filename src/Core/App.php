<?php

namespace Core;


use Controller\BasketController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Request\BasketRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Request\Request;

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
                        if ($requestMethod === 'GET') {
                            $obj->$methodRoute();
                        }else {
                            $requestClass = $this->routes[$requestUri][$requestMethod]['request'];
                            $request = new $requestClass($requestUri, $requestMethod, $_POST);
                            $obj->$methodRoute($request);
                        }


//                        if ($requestUri === '/registration') {
//                            $request = new RegistrateRequest($requestUri,$requestMethod, $_POST);
//                        } elseif ($requestUri === '/login') {
//                            $request = new LoginRequest($requestUri,$requestMethod,$_POST);
//                        }elseif ($requestUri === '/add-product') {
//                            $request = new BasketRequest($requestUri,$requestMethod,$_POST);
//                        }elseif ($requestUri === '/order') {
//                            $request = new OrderRequest($requestUri,$requestMethod,$_POST);
//                        }

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

    public function addRoute(string $uriName, string $uriMethod, string $className, string $method, string $requestClass = null): void
    {
        if(!isset($this->routes[$uriName][$uriMethod])) {
            $this->routes[$uriName][$uriMethod]['class'] = $className;
            $this->routes[$uriName][$uriMethod]['method'] = $method;
            $this->routes[$uriName][$uriMethod]['request'] = $requestClass;
        } else {
            echo "$uriMethod уже зарегистрирован для $uriName" . "<br>";
        }
    }

    public function addGetRoute(string $uriName, string $className, string $method)
    {
        if(!isset($this->routes[$uriName]['GET'])) {
            $this->routes[$uriName]['GET']['class'] = $className;
            $this->routes[$uriName]['GET']['method'] = $method;
        } else {
            echo "'GET' уже зарегистрирован для $uriName" . "<br>";
        }

    }

    public function addPostRoute(string $uriName, string $className, string $method, string $requestClass)
    {
        if(!isset($this->routes[$uriName]['POST'])) {
            $this->routes[$uriName]['POST']['class'] = $className;
            $this->routes[$uriName]['POST']['method'] = $method;
            $this->routes[$uriName]['POST']['request'] = $requestClass;
        } else {
            echo "'POST' уже зарегистрирован для $uriName" . "<br>";
        }

    }

}