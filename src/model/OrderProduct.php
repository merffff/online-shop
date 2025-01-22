<?php

namespace model;
class OrderProduct extends Model
{
    private int $id;
    private int $order_id;
    private int $product_id;
    private int $amount;
    private float $price;

    public function createOrderProduct(int $order_id,int $product_id,int $amount,float $price)
    {

        $stmt = $this->pdo->prepare("INSERT INTO order_product (order_id, product_id, amount, price ) VALUES (:order_id, :product_id,:amount,:price)");


        $stmt->execute(['order_id' => $order_id, 'product_id' => $product_id, 'amount' => $amount, 'price' => $price]);
    }

    public function getAllByOrderId($order_id): ?array
    {
        $place_holders = '?' . str_repeat(', ?',count($order_id) - 1);
        $stmt = $this->pdo->prepare("SELECT * FROM order_product WHERE order_id IN ($place_holders)");
        $stmt->execute($order_id);
        $data = $stmt->fetchAll();
        return $this->hydrateAll($data);


    }

    private function hydrateAll(array $data): ?array
    {
        if ($data === false) {
            return false;
        } else {

            $orderProducts = [];

            foreach ($data as $orderProduct) {

                $obj = new self();
                $obj->id = $orderProduct['id'];
                $obj->order_id = $orderProduct['order_id'];
                $obj->product_id = $orderProduct ['product_id'];
                $obj->amount = $orderProduct ['amount'];
                $obj->price = $orderProduct ['price'];

                $orderProducts[] = $obj;

            }

            return $orderProducts;
        }

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getPrice(): float
    {
        return $this->price;
    }


}