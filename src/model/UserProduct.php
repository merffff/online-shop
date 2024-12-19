<?php
require_once './Model.php';
class UserProduct extends Model
{



    public function getByProductIdAndUserId(int $product_id, int $user_id): array|false
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $productIsset = $stmt->fetch();
        return $productIsset;

    }

    public function create(int $user_id, int $product_id, int $amount)
    {

        $stmt = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function update(int $user_id, int $product_id, int $amount)
    {
        $stmt = $this->pdo->prepare("UPDATE user_products SET amount = amount + :amount WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
    }

    public function getByUserId(int $user_id): array|false
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }

    public function deleteAllByUserId(int $user_id)
    {

        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
    }
}