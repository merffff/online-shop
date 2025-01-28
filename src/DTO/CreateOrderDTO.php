<?php

namespace DTO;

class CreateOrderDTO
{
    public function __construct(
        private int $user_id,
        private int $number,
        private string $name,
        private string $country,
        private string $city,
        private string $street,
        private string $building
    )
    {

    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
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