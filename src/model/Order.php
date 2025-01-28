<?php

namespace model;
class Order extends Model
{

    private int $id;
    private int $user_id;
    private int $address_id;
    private int $number;
    private float $total;
    private $datetime;
    private int $product_id;
    private int $amount;
    private float $price;
    private float $delivery;
    private float $subtotal;
    private string $nameproduct;
    private string $category;
    private string $image;
    private string $country;
    private string $city;
    private string $street;
    private string $building;
    private array $products;
    public function createOrder(int $user_id, int $address_id, int $number, float $total )
    {

        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, address_id, number, total ) VALUES (:user_id, :address_id,:number,:total)");


        $stmt->execute(['user_id' => $user_id, 'address_id' => $address_id, 'number' => $number, 'total' => $total]);
    }

    public function getOneByUserId(int $user_id): self|false
    {

        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id ORDER BY id DESC LIMIT 1");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetch();
        return $this->hydrateOne($data);
    }

    /**
     * @param int $user_id
     * @return Order[]|null
     */
    public function getAllByUserId(int $user_id): array|false
    {

        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        return $this->hydrateAll($data);
    }

    private function hydrateOne(array|bool $data): self|false
    {
        if ($data === false) {
            return false;
        } else {

            $obj = new self();
            $obj->id = $data['id'];
            $obj->user_id = $data['user_id'];
            $obj->address_id = $data ['address_id'];
            $obj->number = $data ['number'];
            $obj->total = $data ['total'];
            $obj->datetime = $data ['datetime'];

            return $obj;
        }

    }

    private function hydrateAll(array|bool $data): array|false
    {
        if ($data === false) {
            return false;
        } else {

            $orders = [];

            foreach ($data as $order) {

                $obj = new self();
                $obj->id = $order['id'];
                $obj->user_id = $order['user_id'];
                $obj->address_id = $order ['address_id'];
                $obj->number = $order ['number'];
                $obj->total = $order ['total'];
                $obj->datetime = $order ['datetime'];

                $orders[] = $obj;

            }

            return $orders;
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

    public function getAddressId(): int
    {
        return $this->address_id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getTotal(): float
    {
        return $this->total;
    }

    public function getDatetime(): string
    {
        return $this->datetime;
    }

    public function getDelivery(): float
    {
        return $this->delivery;
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

    public function getSubtotal(): float
    {
        return $this->subtotal;
    }

    public function getNameproduct(): string
    {
        return $this->nameproduct;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getBuilding(): string
    {
        return $this->building;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
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

    public function setDelivery(float $delivery): void
    {
        $this->delivery = $delivery;
    }

    public function setSubtotal(float $subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setAddressId(int $address_id): void
    {
        $this->address_id = $address_id;
    }

    public function setNumber(int $number): void
    {
        $this->number = $number;
    }

    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    /**
     * @param mixed $datetime
     */
    public function setDatetime($datetime): void
    {
        $this->datetime = $datetime;
    }

    public function setNameproduct(string $nameproduct): void
    {
        $this->nameproduct = $nameproduct;
    }

    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    public function setBuilding(string $building): void
    {
        $this->building = $building;
    }









}