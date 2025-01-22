<?php

namespace model;
class Product extends Model
{
    private int $id;
    private string $nameproduct;
    private string $category;
    private int $productcount;
    private string $image;
    private float $price;
    private int $amount;
    public function getProducts(): ?array
    {

        $stmt = $this->pdo->query("SELECT * FROM products");
        $data = $stmt->fetchAll();


        return $this->hydrateAll($data);
    }

    public function getById(int $product_id): ?self
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $product_id]);
        $data = $stmt->fetch();

        return $this->hydrateOne($data);

    }

    public function getByUserIdDataBasket(int $user_id): ?array
    {


        $stmt = $this->pdo->prepare("SELECT amount, nameproduct, price, image FROM products JOIN user_products ON user_products.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();

        return $this->hydrateAll($data);

    }

    public function getAllByIds($product_id): ?array
    {
        $place_holders = '?' . str_repeat(', ?',count($product_id) - 1);
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id IN ($place_holders)");
        $stmt->execute($product_id);
        $data = $stmt->fetchAll();

        return $this->hydrateAll($data);

    }

    private function hydrateAll(array $data): ?array
    {
        if ($data === false) {
            return false;
        } else {
            $products = [];

            foreach ($data as $product) {

                $obj = new self();
                $obj->id = $product['id'];
                $obj->nameproduct = $product['nameproduct'];
                $obj->category = $product ['category'];
                $obj->productcount = $product ['productcount'];
                $obj->image = $product ['image'];
                $obj->price = $product ['price'];

                $products[] = $obj;

            }

            return $products;
        }

    }
    private function hydrateOne(array $data): ?self
    {
        if ($data === false) {
            return false;
        } else {

            $obj = new self();
            $obj->id = $data['id'];
            $obj->nameproduct = $data['nameproduct'];
            $obj->category = $data ['category'];
            $obj->productcount = $data ['productcount'];
            $obj->image = $data ['image'];
            $obj->price = $data ['price'];

            return $obj;
        }

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNameproduct(): string
    {
        return $this->nameproduct;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getProductcount(): int
    {
        return $this->productcount;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }


    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNameproduct(string $nameproduct): void
    {
        $this->nameproduct = $nameproduct;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function setProductcount(int $productcount): void
    {
        $this->productcount = $productcount;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }




}