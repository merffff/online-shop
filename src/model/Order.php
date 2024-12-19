<?php

class Order
{
    public function createOrder(int $user_id, int $address_id, int $number, float $total )
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, address_id, number, total ) VALUES (:user_id, :address_id,:number,:total)");


        $stmt->execute(['user_id' => $user_id, 'address_id' => $address_id, 'number' => $number, 'total' => $total]);
    }

    public function getOneByUserId(int $user_id): array|false
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetch();
    }

}