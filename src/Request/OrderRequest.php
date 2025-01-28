<?php

namespace Request;

class OrderRequest extends Request
{
    public function getNumber(): ?int
    {
        return $this->data['number'] ?? null;
    }

    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function getCountry(): ?string
    {
        return $this->data['country'] ?? null;
    }

    public function getCity(): ?string
    {
        return $this->data['city'] ?? null;
    }
    public function getStreet(): ?string
    {
        return $this->data['street'] ?? null;
    }

    public function getBuilding(): ?string
    {
        return $this->data['building'] ?? null;
    }


    public function validate(): array
    {
        $error = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];

            if (empty($name)) {
                $error['name'] = 'имя не может быть пустым';
            } elseif (strlen($name) < 2) {
                $error['name'] = 'имя не может содержать меньше двух букв';
            } elseif (is_numeric($name)) {
                echo $error['name'] = 'имя не может быть числом';
            }
        } else {
            $error['name'] = 'name is required';
        }


        if (isset($this->data['email'])) {
            $email = $this->data['email'];

            if (empty($email)) {
                $error['email'] = 'email не может быть пустым';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'email указан неверно';
            }
        } else {
            $error['email'] = 'email is required';
        }

        if (isset($this->data['number'])) {
            $number = $this->data['number'];

            if (empty($number)) {
                $error['number'] = 'номер телефона не может быть пустым';
            } elseif (!is_numeric($number)) {
                echo $error['number'] = 'номер телефона не может быть символом';
            }elseif ($number<69999999999) {
                $error['number'] = 'номер телефона должен содержать 11 цифр';
            }
        } else {
            $error['number'] = 'number is required';
        }

        if (isset($this->data['country'])) {
            $country = $this->data['country'];

            if (empty($country)) {
                $error['country'] = 'страна не может быть пустой';
            } elseif (strlen($country) < 2) {
                $error['country'] = 'страна не может содержать меньше двух букв';
            } elseif (is_numeric($country)) {
                echo $error['country'] = 'страна не может быть числом';
            }
        } else {
            $error['country'] = 'country is required';
        }

        if (isset($this->data['city'])) {
            $city = $this->data['city'];

            if (empty($city)) {
                $error['city'] = 'город не может быть пустым';
            } elseif (strlen($city) < 2) {
                $error['city'] = 'город не может содержать меньше двух букв';
            } elseif (is_numeric($city)) {
                echo $error['city'] = 'город не может быть числом';
            }
        } else {
            $error['city'] = 'city is required';
        }

        if (isset($this->data['street'])) {
            $street = $this->data['street'];

            if (empty($street)) {
                $error['street'] = 'улица не может быть пустым';
            } elseif (strlen($street) < 2) {
                $error['street'] = 'улица не может содержать меньше двух символов';
            }
        } else {
            $error['street'] = 'street is required';
        }

        if (isset($this->data['building'])) {
            $building = $this->data['building'];

            if (empty($building)) {
                $error['building'] = 'номер здания не может быть пустым';
            } elseif ($building< 0) {
                $error['building'] = 'номер здания не может быть отрицательным числом';
            } elseif (!is_numeric($building)) {
                echo $error['building'] = 'номер здания не может быть символом';
            }
        } else {
            $error['building'] = 'building is required';
        }

        return $error;


    }




}