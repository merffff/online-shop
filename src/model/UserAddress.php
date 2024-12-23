<?php

require_once './Model.php';

class UserAddress extends Model
{

    public function createUserAddress(int $user_id, string $country, string $city, string $street, string $building)
    {

        $stmt = $this->pdo->prepare("INSERT INTO user_addresses (user_id, country, city, street, building ) VALUES (:user_id, :country,:city,:street,:building)");

        $stmt->execute(['user_id' => $user_id, 'country' => $country, 'city' => $city, 'street' => $street, 'building' => $building]);
    }

    public function getById (int $user_id): array
    {

        $stmt = $this->pdo->prepare("SELECT id FROM user_addresses WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetch();
        return $data;
    }
}