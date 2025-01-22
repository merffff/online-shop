<?php

namespace model;
class UserProduct extends Model
{
    private int $id;
    private int $user_id;
    private int $product_id;
    private int $amount;
    private float $price;



    public function getByProductIdAndUserId(int $product_id, int $user_id): self|false
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :user_id");
        $stmt->execute(['product_id' => $product_id, 'user_id' => $user_id]);
        $productIsset = $stmt->fetch();
        return $this->hydrateOne($productIsset);

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

    public function getByUserId(int $user_id): ?array
    {

        $stmt = $this->pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        return $this->hydrateAll($data);
    }

    public function deleteAllByUserId(int $user_id)
    {

        $stmt = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
    }

    private function hydrateOne( $data): self|false
    {
        if ($data === false) {
            return false;
        } else {

            $obj = new self();
            $obj->id = $data['id'];
            $obj->user_id = $data['user_id'];
            $obj->product_id = $data ['product_id'];
            $obj->amount = $data ['amount'];

            return $obj;
        }

    }
    private function hydrateAll(array $data): ?array
    {
        if ($data === false) {
            return false;
        } else {


            $userProducts = [];

            foreach ($data as $userProduct) {
                $obj = new self();
                $obj->id = $userProduct['id'];
                $obj->user_id = $userProduct['user_id'];
                $obj->product_id = $userProduct ['product_id'];
                $obj->amount = $userProduct ['amount'];

                $userProducts[] = $obj;

            }

            return $userProducts;
        }

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
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

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }




}