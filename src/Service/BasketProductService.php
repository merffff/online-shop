<?php

namespace Service;


use model\Model;
use model\Product;

use model\UserProduct;

class BasketProductService
{
    private UserProduct $userProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    public function getUserProduct(int $user_id): array|false
    {
        $userProducts = $this->userProductModel->getByUserId($user_id);

        $products =[];

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $product = $this->productModel->getById($productId);
            $product->setAmount($userProduct->getAmount());
            $products[] =$product;

        }
        return $products;

    }

    public function getTotal(array $products): float
    {
        $total = 0;
        foreach ($products as $product) {
            $product->setSum($product->getAmount()*$product->getPrice());
            $total = $total+$product->getSum();
        }

        return $total;

    }

    public function getDelivery(float $total): float
    {
        if ($total >= 250000) {
            $delivery = 0;
        } else {
            $delivery = 500;
        }
        return $delivery;
    }

    public function getSubtotal(float $delivery, float $total): float
    {
        $subtotal = $delivery + $total;
        return $subtotal;
    }




}