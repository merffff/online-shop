<?php

namespace Service\Auth;

use model\User;

class AuthCookieService implements AuthServiceInterface
{
    public function check():bool
    {

        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->check()){
            return null;
        }

        $user_id = $_COOKIE['user_id'];

        return User::getById($user_id);
    }

    public function login(string $login, string $password):bool
    {
        $user = User::getByLogin($login);

        if(($user!==null) and password_verify($password,$user->getPassword())) {
            $_COOKIE['user_id'] = $user->getId();
            return true;
        }
        return false;


    }

}