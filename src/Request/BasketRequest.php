<?php

namespace Request;
use model\Product;
use model\User;

class BasketRequest extends Request
{
    private Product $productModel;

    public function __construct(string $uri, string $method, array $data = [])
    {
        parent::__construct($uri, $method, $data);
        $this->productModel = new Product();
    }

    public function getProductId(): ?int
    {
        return $this->data['product_id'] ?? null;
    }

    public function getAmount(): ?int
    {
        return $this->data['amount'] ?? null;
    }

    public function validate(): array
    {
        $error = [];

        if (isset($this->data['product_id'])) {
            $product_id = $this->data['product_id'];

            if (empty($product_id)) {
                $error['product_id'] = 'id не может быть пустым';
            } elseif (!is_numeric($product_id)) {
                echo $error['product_id'] = 'id не может быть символом';
            }elseif ($product_id<1) {
                $error['product_id'] = 'id должно быть положительным числом';
            }else {
                $res = $this->productModel->getById($product_id);

                if ($res === false) {
                    $error['product_id'] = 'продукта с указанным id не существует';
                }
            }
        } else {
            $error['product_id'] = 'product-id is required';
        }


        if (isset($this->data['amount'])) {
            $amount = $this->data['amount'];

            if (empty($amount)) {
                $error['amount'] = 'количество не может быть пустым';
            } elseif (!is_numeric($amount)) {
                $error['amount'] = 'введите целое число';
            } elseif ($amount<1) {
                $error['amount'] = 'количество должно быть положительным числом';
            }
        } else {
            $error['amount'] = 'amount is required';
        }


        return $error;
    }

}