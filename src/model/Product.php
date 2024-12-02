<?php

class Product
{
    public function getProducts()
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        return $products;
    }

}