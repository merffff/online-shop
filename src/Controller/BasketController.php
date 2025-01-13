<?php

namespace Controller;
use model\UserProduct;
use model\Product;


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

    public function addProduct()
    {
        $error = $this->validateAddProduct($_POST);


        if (empty($error)) {

            $this->checkSession();

            $user_id=$_SESSION['user_id'];
            $product_id = $_POST['product_id'];
            $amount = $_POST['amount'];

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

    private function validateAddProduct(array $arrPost): array
    {
        $error = [];

        if (isset($arrPost['product_id'])) {
            $product_id = $arrPost['product_id'];

            if (empty($product_id)) {
                $error['product_id'] = 'id не может быть пустым';
            } elseif (!is_numeric($product_id)) {
                echo $error['product_id'] = 'id не может быть символом';
            }elseif ($product_id<1) {
                $error['product_id'] = 'id должно быть положительным числом';
            }else {
                $res = $this->productModel->getById($product_id);

                if ($res === false) {
                    $error['product_id'] = 'продукта с указанным id не существует';
                }
            }
        } else {
            $error['product_id'] = 'product-id is required';
        }


        if (isset($arrPost['amount'])) {
            $amount = $arrPost['amount'];

            if (empty($amount)) {
                $error['amount'] = 'количество не может быть пустым';
            } elseif (!is_numeric($amount)) {
                $error['amount'] = 'введите целое число';
            } elseif ($amount<1) {
                $error['amount'] = 'количество должно быть положительным числом';
            }
        } else {
            $error['amount'] = 'amount is required';
        }


        return $error;
    }

    public function getBasket()
    {
        $this->checkSession();



        $user_id = $_SESSION['user_id'];

        $userProducts = $this->userProductModel->getByUserId($user_id);

        $products =[];

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct['product_id'];
            $product = $this->productModel->getById($productId);
            $product['amount'] = $userProduct['amount'];
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