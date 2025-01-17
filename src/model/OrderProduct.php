<?php

namespace model;
class OrderProduct extends Model
{

    public function createOrderProduct(int $order_id,int $product_id,int $amount,float $price)
    {

        $stmt = $this->pdo->prepare("INSERT INTO order_product (order_id, product_id, amount, price ) VALUES (:order_id, :product_id,:amount,:price)");


        $stmt->execute(['order_id' => $order_id, 'product_id' => $product_id, 'amount' => $amount, 'price' => $price]);
    }

    public function getAllByOrderId($order_id): array|false
    {
        $place_holders = '?' . str_repeat(', ?',count($order_id) - 1);
        $stmt = $this->pdo->prepare("SELECT * FROM order_product WHERE order_id IN ($place_holders)");
        $stmt->execute($order_id);
        return $stmt->fetchAll();


    }
}