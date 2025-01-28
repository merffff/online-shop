<?php

namespace Controller;
use model\Product;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getCatalog()
    {
       $this->checkSession();

        $products = $this->productModel->getProducts();

        require_once './../view/catalog.php';
    }

    private function checkSession():void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
    }
}