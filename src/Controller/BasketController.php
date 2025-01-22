<?php

namespace Controller;
use model\UserProduct;
use model\Product;
use Request\BasketRequest;


class BasketController
{
    private UserProduct $userProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
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

        $userProducts = $this->userProductModel->getByUserId($user_id);

        $products =[];

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $product = $this->productModel->getById($productId);
            $product->setAmount($userProduct->getAmount());
            $products[] =$product;
        }

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