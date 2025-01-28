<?php

namespace Controller;
use model\UserProduct;
use Request\BasketRequest;
use Service\BasketProductService;


class BasketController
{
    private UserProduct $userProductModel;
    private BasketProductService $productService;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productService = new BasketProductService();
    }

    public function getAddProduct()
    {
        $this->checkSession();

        require_once './../view/addProduct.php';
    }

    public function addProduct(BasketRequest $request)
    {
        $error = $request->validate();


        if (empty($error)) {

            $this->checkSession();

            $user_id=$_SESSION['user_id'];
            $product_id = $request->getProductId();
            $amount = $request->getAmount();

            $productIsset = $this->userProductModel->getByProductIdAndUserId($product_id, $user_id);

            if ($productIsset === false) {
                $this->userProductModel->create($user_id, $product_id, $amount);
            } else {
                $this->userProductModel->update($user_id,$product_id,$amount);
            }


            header("Location: /basket");
            exit;
        } else {
            require_once './../view/addProduct.php';
        }

    }


    public function getBasket()
    {
        $this->checkSession();



        $user_id = $_SESSION['user_id'];

        $products = $this->productService->getUserProduct($user_id);
        $total = $this->productService->getTotal($products);
        $delivery = $this->productService->getDelivery($total);
        $subtotal = $this->productService->getSubtotal($delivery, $total);


            //$userProducts = $this->productModel->getByUserIdDataBasket($user_id);


        require_once './../view/basket.php';

    }

    private function checkSession():void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
    }
}