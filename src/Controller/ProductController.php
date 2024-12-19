<?php

require_once './../model/Product.php';


class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getCatalog()
    {
        session_start();

        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        $products = $this->productModel->getProducts();

        require_once './../view/catalog.php';
    }
}