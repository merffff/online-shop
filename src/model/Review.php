<?php

namespace model;

class Review extends Model
{
    private int $id;
    private int $product_id;
    private string $text;
    private int $rate;
    private int $user_id;
    private string $datetime;
    public static function createReview(int $product_id,string $text, int $rate, int $user_id, string $datetime )
    {

        $stmt = self::getPdo()->prepare("INSERT INTO reviews (product_id, text, rate, user_id, datetime ) VALUES (:product_id, :text,:rate,:user_id,:datetime)");


        $stmt->execute(['product_id' => $product_id, 'text' => $text, 'rate' => $rate, 'user_id' => $user_id, 'datetime'=>$datetime]);
    }

    public static function getAllByProductId(int $product_id): array|false
    {
        $stmt = self::getPdo()->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetchAll();
        return self::hydrateAll($data);
    }

    private static function hydrateAll(array|bool $data): array|false
    {
        if ($data === false) {
            return false;
        } else {


            $reviews = [];

            foreach ($data as $review) {
                $obj = new self();
                $obj->id = $review['id'];
                $obj->product_id = $review['product_id'];
                $obj->text = $review ['text'];
                $obj->rate = $review ['rate'];
                $obj->user_id = $review ['user_id'];
                $obj->datetime = $review ['datetime'];

                $reviews[] = $obj;

            }

            return $reviews;
        }



    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getRate(): int
    {
        return $this->rate;
    }

    public function setRate(int $rate): void
    {
        $this->rate = $rate;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getDatetime(): string
    {
        return $this->datetime;
    }

    public function setDatetime(string $datetime): void
    {
        $this->datetime = $datetime;
    }

}