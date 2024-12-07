<?php



class User
{
    public function create(string $name, string $email, string $login, string $password)
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO users (name, email,login, password) VALUES (:name, :email,:login,:password)");


        $stmt->execute(['name' => $name, 'email' => $email, 'login' => $login, 'password' => $password]);
    }

    public function getByLogin (string $login): array|false
    {
        $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
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


}