<?php

namespace model;
class UserAddress extends Model
{
    private int $id;
    private int $user_id;
    private string $country;
    private string $city;
    private string  $street;
    private string $building;

    public static function createUserAddress(int $user_id, string $country, string $city, string $street, string $building)
    {

        $stmt = self::getPdo()->prepare("INSERT INTO user_addresses (user_id, country, city, street, building ) VALUES (:user_id, :country,:city,:street,:building)");

        $stmt->execute(['user_id' => $user_id, 'country' => $country, 'city' => $city, 'street' => $street, 'building' => $building]);
    }

    public static function getById (int $user_id): self|false
    {

        $stmt = self::getPdo()->prepare("SELECT * FROM user_addresses WHERE user_id = :user_id ORDER BY id DESC");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetch();
        return self::hydrateOne($data);
    }

    public static function getAddressesByIds($address_id): array|false
    {
        $place_holders = '?' . str_repeat(', ?',count($address_id) - 1);
        $stmt = self::getPdo()->prepare("SELECT * FROM user_addresses WHERE id IN ($place_holders)");
        $stmt->execute($address_id);
        $data = $stmt->fetchAll();

        return self::hydrateAll($data);


    }

    private static function hydrateAll(array|bool $data): array|false
    {
        if ($data === false) {
            return false;
        } else {

            $addresses = [];

            foreach ($data as $address) {

                $obj = new self();
                $obj->id = $address['id'];
                $obj->user_id = $address['user_id'];
                $obj->country = $address ['country'];
                $obj->city = $address ['city'];
                $obj->street = $address ['street'];
                $obj->building = $address['building'];

                $addresses[] = $obj;

            }

            return $addresses;
        }

    }

    private static function hydrateOne(array|bool $data): self|false
    {
        if ($data === false) {
            return false;
        } else {


            $obj = new self();
            $obj->id = $data['id'];
            $obj->user_id = $data['user_id'];
            $obj->country = $data ['country'];
            $obj->city = $data ['city'];
            $obj->street = $data ['street'];
            $obj->building = $data['building'];

            return $obj;
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

}