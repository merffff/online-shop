<?php

namespace Request;
use model\User;

class RegistrateRequest extends Request
{
    private User $userModel;

    public function __construct(string $uri, string $method, array $data = [])
    {
        parent::__construct($uri, $method, $data);
        $this->userModel = new User();
    }
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function getEmail(): ?string
    {
        return $this->data['email'] ?? null;
    }

    public function getlogin(): ?string
    {
        return $this->data['login'] ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->data['password'] ?? null;
    }

    public function getPasswordRep(): ?string
    {
        return $this->data['passwordRep'] ?? null;
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
            } else {

                $user = $this->userModel->getByEmail($email);

                if ($user !== false) {
                    $error['email'] = 'пользователь с указанной почтой существует';
                }
            }
        } else {
            $error['email'] = 'email is required';
        }

        if (isset($this->data['login'])) {
            $login = $this->data['login'];

            if (empty($login)) {
                $error['login'] = 'логин не может быть пустым';
            } elseif (strlen($login) < 2) {
                $error['login'] = 'логин не может содержать меньше двух символов';
            } elseif (is_numeric($login)) {
                echo $error['login'] = 'логин не должен содержать только цифры';
            }
        } else {
            $error['login'] = 'login is required';
        }

        if (isset($this->data['password'])) {
            $password = $this->data['password'];

            if (empty($password)) {
                $error['password'] = 'пароль не может быть пустым';
            } elseif (strlen($password) < 8) {
                $error['password'] = 'пароль должен содержать не менее 8 символов';
            } elseif (is_numeric($password)) {
                $error['password'] = 'пароль не должен содержать только цифры';
            }
        } else {
            $error['password'] = 'password is required';
        }

        if (isset($this->data['passwordRep'])) {
            $passwordRep = $this->data['passwordRep'];

            if (empty($passwordRep)) {
                $error['passwordRep'] = 'поле не должно быть пустым';
            } elseif ($passwordRep !== $password) {
                $error['passwordRep'] = 'пароль не совпадает';
            }
        } else {
            $error['passwordRep'] = 'repeat password is required';
        }

        return $error;
    }





}