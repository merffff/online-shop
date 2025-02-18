<?php

namespace Controller;
use model\UserProduct;
use Request\BasketRequest;
use Service\Auth\AuthServiceInterface;
use Service\AuthService;
use Service\BasketProductService;


class BasketController
{
    private BasketProductService $productService;
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService, BasketProductService $productService)
    {
        $this->productService = $productService;
        $this->authService = $authService;
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

            $this->productService->addProduct($product_id, $user_id, $amount);

            header("Location: /basket");
            exit;
        } else {
            require_once './../view/addProduct.php';
        }

    }

    public function addProducts(BasketRequest $request)
    {
        $this->checkSession();

        $errors = $request->validate();
        $user_id = $this->authService->getCurrentUser()->getId();

        if (empty($errors)) {
            $product_id = $request->getProductId();
            $amount = $request->getAmount();

            $this->productService->addProduct($product_id,$user_id, $amount);
            $totalAmount = UserProduct::getAmountByUserId($user_id);
            $response = ['success' => true, 'totalAmount' => $totalAmount->getTotalAmount()];
            echo json_encode($response);
            exit;


        }
        header("Location: /catalog");
    }
    public function deleteProducts(BasketRequest $request)
    {
        $this->checkSession();
        $errors = $request->validate();
        $user_id = $this->authService->getCurrentUser()->getId();

        if (empty($errors)) {
            $product_id = $request->getProductId();
            $amount = $request->getAmount();
            UserProduct::deleteProduct($user_id, $product_id, $amount);
            $totalAmount = UserProduct::getAmountByUserId($user_id);
            $response = ['success' => true, 'totalAmount' => $totalAmount->getTotalAmount()];
            echo json_encode($response);
            exit;
        }
        header("Location: /catalog");
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