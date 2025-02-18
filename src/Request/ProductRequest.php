<?php

namespace Request;

class ProductRequest extends Request
{
    public function getProductId(): ?int
    {
        return $this->data['product_id'] ?? null;
    }

}