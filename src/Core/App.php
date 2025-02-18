<?php

namespace Core;


use Service\Logger\LoggerFileService;
use Service\Logger\LoggerServiceInterface;

class App
{
    private LoggerServiceInterface $loggerService;
    private Container $container;

    private array $routes = [];

    public function __construct(LoggerServiceInterface $loggerService, Container $container)
    {
        $this->loggerService = $loggerService;
        $this->container = $container;

    }
    public function run(): void
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER ['REQUEST_METHOD'];

        if (array_key_exists($requestUri, $this->routes)){
            if (array_key_exists($requestMethod, $this->routes[$requestUri])) {
                $class = $this->routes[$requestUri][$requestMethod]['class'];
                $object = $this->container->get($class);
                $method = $this->routes[$requestUri][$requestMethod]['method'];
                $requestClass = $this->routes[$requestUri][$requestMethod]['request'];
                if (!empty($requestClass)) {
                        $request = new $requestClass($requestUri, $requestMethod, $_POST);

                    try {
                        $object->$method($request);
                    } catch (\Throwable $exception) {
                        $this->loggerService->error($exception);
                        http_response_code(500);
                        require_once "./../view/500.php";
                    }
                } else {
                    try{
                        $object->$method();
                    } catch (\Throwable $exception) {
                        $this->loggerService->error($exception);
                        http_response_code(500);
                        require_once "./../view/500.php";
                    }
                }

            } else {
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

    public function addGetRoute(string $uriName, string $className, string $method, string $requestClass = null): void
    {
        if(!isset($this->routes[$uriName]['GET'])) {
            $this->routes[$uriName]['GET']['class'] = $className;
            $this->routes[$uriName]['GET']['method'] = $method;
            $this->routes[$uriName]['GET']['request'] = $requestClass;
        } else {
            echo "'GET' уже зарегистрирован для $uriName" . "<br>";
        }

    }

    public function addPostRoute(string $uriName, string $className, string $method, string $requestClass): void
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