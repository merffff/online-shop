<?php

namespace Controller;
use model\UserProduct;
use Request\BasketRequest;
use Service\AuthService;
use Service\BasketProductService;


class BasketController
{
    private UserProduct $userProductModel;
    private BasketProductService $productService;
    private AuthService $authService;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productService = new BasketProductService();
        $this->authService = new AuthService();
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

            $user_id = $this->authService->getCurrentUser()->getId();
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



        $user_id = $this->authService->getCurrentUser()->getId();

        $products = $this->productService->getUserProduct($user_id);
        $total = $this->productService->getTotal($products);
        $delivery = $this->productService->getDelivery($total);
        $subtotal = $this->productService->getSubtotal($delivery, $total);


            //$userProducts = $this->productModel->getByUserIdDataBasket($user_id);


        require_once './../view/basket.php';

    }

    private function checkSession():void
    {

        if (!$this->authService->check()) {
            header("Location: /login");
        }
    }
}