<?php
require_once './../Controller/OrderController.php';
require_once './../Controller/UserController.php';
require_once './../Controller/ProductController.php';
require_once './../Controller/BasketController.php';


class App
{

    private array $routes = [
        '/registration'=>[
            'GET'=>[
                'class'=>'UserController',
                'method'=>'getRegistrationForm',
            ],
            'POST'=>[
                'class'=>'UserController',
                'method'=>'registrate',
            ]
        ],
        '/login'=>[
            'GET'=>[
                'class'=>'UserController',
                'method'=>'getLoginForm',
            ],
            'POST'=>[
                'class'=>'UserController',
                'method'=>'login',
            ]
        ],
        '/catalog'=>[
            'GET'=>[
                'class'=>'ProductController',
                'method'=>'getCatalog',
            ],
        ],
        '/add-product'=>[
            'GET'=>[
                'class'=>'BasketController',
                'method'=>'getAddProduct',
            ],
            'POST'=>[
                'class'=>'BasketController',
                'method'=>'addProduct',
            ]
        ],
        '/logout'=>[
            'GET'=>[
                'class'=>'UserController',
                'method'=>'logout',
            ],
        ],
        '/basket'=>[
            'GET'=>[
                'class'=>'BasketController',
                'method'=>'getBasket',
            ],
        ],
        '/order'=>[
            'GET'=>[
                'class'=>'OrderController',
                'method'=>'getOrder',
            ],
            'POST'=>[
                'class'=>'OrderController',
                'method'=>'handleOrder',
            ]
        ],
        '/completedOrder'=>[
            'GET'=>[
                'class'=>'OrderController',
                'method'=>'completedOrder',
            ],
        ],
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