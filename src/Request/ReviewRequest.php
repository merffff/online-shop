<?php

namespace Request;

class ReviewRequest extends Request
{
    public function getText(): ?string
    {
        return $this->data['text'] ?? null;
    }

    public function getRate(): ?int
    {
        return $this->data['rate'] ?? null;
    }

    public function getProductId(): ?int
    {
        return $this->data['product_id'] ?? null;
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

        if (isset($this->data['text'])) {
            $text = $this->data['text'];

            if (empty($text)) {
                $error['text'] = 'отзыв не может быть пустым';
            } elseif (strlen($text) < 2) {
                $error['text'] = 'отзыв не может содержать меньше двух символов';
            } elseif (is_numeric($text)) {
                echo $error['text'] = 'отзыв не должен содержать только цифры';
            }
        } else {
            $error['text'] = 'text is required';
        }

        if (isset($this->data['rate'])) {
            $rate = $this->data['rate'];
        } else {
            $error['rate'] = 'rate is required';
        }

        return $error;

    }




}