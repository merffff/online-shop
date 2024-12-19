<?php

class UserAddress
{

    public function createUserAddress(int $user_id, string $country, string $city, string $street, string $building)
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO user_addresses (user_id, country, city, street, building ) VALUES (:user_id, :country,:city,:street,:building)");


        $stmt->execute(['user_id' => $user_id, 'country' => $country, 'city' => $city, 'street' => $street, 'building' => $building]);
    }

    public function getById (int $user_id): array
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("SELECT id FROM user_addresses WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetch();
        return $data;
    }
}