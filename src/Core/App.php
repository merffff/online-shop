<?php

namespace Core;


use Controller\BasketController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;

class App
{

    private array $routes = [
        '/registration'=>[
            'GET'=>[
                'class'=>UserController::class,
                'method'=>'getRegistrateForm',
            ],
            'POST'=>[
                'class'=>UserController::class,
                'method'=>'registrate',
            ]
        ],
        '/login'=>[
            'GET'=>[
                'class'=>UserController::class,
                'method'=>'getLoginForm',
            ],
            'POST'=>[
                'class'=>UserController::class,
                'method'=>'login',
            ]
        ],
        '/catalog'=>[
            'GET'=>[
                'class'=>ProductController::class,
                'method'=>'getCatalog',
            ],
        ],
        '/add-product'=>[
            'GET'=>[
                'class'=>BasketController::class,
                'method'=>'getAddProduct',
            ],
            'POST'=>[
                'class'=>BasketController::class,
                'method'=>'addProduct',
            ]
        ],
        '/logout'=>[
            'GET'=>[
                'class'=>UserController::class,
                'method'=>'logout',
            ],
        ],
        '/basket'=>[
            'GET'=>[
                'class'=>BasketController::class,
                'method'=>'getBasket',
            ],
        ],
        '/order'=>[
            'GET'=>[
                'class'=>OrderController::class,
                'method'=>'getOrder',
            ],
            'POST'=>[
                'class'=>OrderController::class,
                'method'=>'handleOrder',
            ]
        ],
        '/completedOrder'=>[
            'GET'=>[
                'class'=>OrderController::class,
                'method'=>'completedOrder',
            ],
        ],
        '/orders'=>[
            'GET'=>[
                'class'=>OrderController::class,
                'method'=>'getOrders',
            ]
        ]
    ];
    public function run()
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

}