<?php

namespace model;
class Product extends Model
{
    public function getProducts()
    {

        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getById(int $product_id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $product_id]);
        return $stmt->fetch();

    }

    public function getByUserIdDataBasket(int $user_id):array|false
    {


        $stmt = $this->pdo->prepare("SELECT amount, nameproduct, price, image FROM products JOIN user_products ON user_products.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();

    }

    public function getAllByIds($product_id): array|false
    {
        $place_holders = '?' . str_repeat(', ?',count($product_id) - 1);
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id IN ($place_holders)");
        $stmt->execute($product_id);
        return $stmt->fetchAll();

    }

}