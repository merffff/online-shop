<?php

namespace Controller;
use model\Product;
use Service\AuthService;

class ProductController
{
    private Product $productModel;
    private AuthService $authService;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->authService = new AuthService();
    }

    public function getCatalog()
    {
       $this->checkSession();

        $products = $this->productModel->getProducts();

        require_once './../view/catalog.php';
    }

    private function checkSession():void
    {

        if (!$this->authService->check()) {
            header("Location: /login");
        }
    }
}