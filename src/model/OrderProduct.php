<?php

class OrderProduct
{

    public function createOrderProduct(int $order_id,int $product_id,int $amount,float $price)
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO order_product (order_id, product_id, amount, price ) VALUES (:order_id, :product_id,:amount,:price)");


        $stmt->execute(['order_id' => $order_id, 'product_id' => $product_id, 'amount' => $amount, 'price' => $price]);
    }
}