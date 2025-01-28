<?php

namespace Request;



class LoginRequest extends Request
{

    public function getlogin(): ?string
    {
        return $this->data['login'] ?? null;
    }

    public function getPassword(): ?string
    {
        return $this->data['password'] ?? null;
    }


    public function validate(): array
    {

        $error = [];

        if (isset($this->data['login'])) {
            $login = $this->data['login'];

            if (empty($login)) {
                $error['login'] = 'логин не может быть пустым';
            }
        } else {
            $error['login'] = 'login is required';
        }

        if (isset($this->data['password'])) {
            $password = $this->data['password'];

            if (empty($password)) {
                $error['password'] = 'пароль не может быть пустым';
            }
        } else {
            $error['password'] = 'password is required';
        }

        return $error;
    }

}