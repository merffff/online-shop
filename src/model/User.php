<?php

namespace model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $login;
    private string $password;
    public static function create(string $name, string $email, string $login, string $password)
    {
        $stmt = self::getPdo()->prepare("INSERT INTO users (name, email,login, password) VALUES (:name, :email,:login,:password)");

        $stmt->execute(['name' => $name, 'email' => $email, 'login' => $login, 'password' => $password]);
    }

    public static function getByLogin (string $login): ?self
    {

        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $data = $stmt->fetch();

        return self::hydrate($data);
    }

    public static function getByEmail(string $email): ?self
    {

        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        return self::hydrate($data);
    }

    public static function getById(int $id): self|false
    {

        $stmt = self::getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();

        return self::hydrate($data);
    }

    private static function hydrate(array|bool $data): self|false
    {
        if ($data === false) {
            return false;
        } else {

            $obj = new self();
            $obj->id = $data['id'];
            $obj->name = $data['name'];
            $obj->email = $data ['email'];
            $obj->login = $data ['login'];
            $obj->password = $data ['password'];

            return $obj;
        }

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }




}