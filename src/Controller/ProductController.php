<?php



class ProductController
{

    public function getCatalog()
    {
        session_start();

        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }

        require_once './../model/Product.php';
        $products = new Product();
        $products = $products->getProducts();


        require_once './../view/catalog.php';
    }
}