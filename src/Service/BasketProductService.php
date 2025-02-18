<?php

namespace Service;


use model\Model;
use model\Product;

use model\UserProduct;

class BasketProductService
{

    public function getUserProduct(int $user_id): array|false
    {
        $userProducts = UserProduct::getByUserId($user_id);

        $products =[];

        foreach ($userProducts as $userProduct) {
            $productId = $userProduct->getProductId();
            $product = Product::getById($productId);
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

    public function addProduct(int $product_id, int $user_id, int $amount)
    {
        $productIsset = UserProduct::getByProductIdAndUserId($product_id, $user_id);

        if ($productIsset === false) {
            UserProduct::create($user_id, $product_id, $amount);
        } else {
            UserProduct::update($user_id,$product_id,$amount);
        }

    }




}