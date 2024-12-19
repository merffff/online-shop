<?php

require_once './Model.php';


class User extends Model
{
    public function create(string $name, string $email, string $login, string $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email,login, password) VALUES (:name, :email,:login,:password)");

        $stmt->execute(['name' => $name, 'email' => $email, 'login' => $login, 'password' => $password]);
    }

    public function getByLogin (string $login): array|false
    {

        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();
        return $data;
    }

    public function getByEmail(string $email): array|false
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();
        return $data;
    }

    public function getEmailById(int $id): array
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT email FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        return $data;
    }


}