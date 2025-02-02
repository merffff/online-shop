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
    private int $orderId;
    private float $sum;
    public static function getProducts(): array|false
    {

        $stmt = self::getPdo()->query("SELECT * FROM products");
        $data = $stmt->fetchAll();


        return self::hydrateAll($data);
    }

    public static function getById(int $product_id): self|false
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->execute(['id' => $product_id]);
        $data = $stmt->fetch();

        return self::hydrateOne($data);

    }

    public static function getByUserIdDataBasket(int $user_id): array|false
    {


        $stmt = self::getPdo()->prepare("SELECT amount, nameproduct, price, image FROM products JOIN user_products ON user_products.product_id = products.id WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();

        return self::hydrateAll($data);

    }

    public static function getAllByIds($product_id): array|false
    {
        $place_holders = '?' . str_repeat(', ?',count($product_id) - 1);
        $stmt = self::getPdo()->prepare("SELECT * FROM products WHERE id IN ($place_holders)");
        $stmt->execute($product_id);
        $data = $stmt->fetchAll();

        return self::hydrateAll($data);

    }

    private static function hydrateAll(array|bool $data): array|false
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
    private static function hydrateOne(array|bool $data): self|false
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

    public function getOrderId(): int
    {
        return $this->orderId;
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

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getSum(): float
    {
        return $this->sum;
    }

    public function setSum(float $sum): void
    {
        $this->sum = $sum;
    }






}