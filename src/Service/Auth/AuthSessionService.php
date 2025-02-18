<?php

namespace Service\Auth;

use model\User;

class AuthSessionService implements AuthServiceInterface
{
    public function check():bool
    {
        $this->sessionStart();

        return isset($_SESSION['user_id']);
    }

    public function getCurrentUser(): ?User
    {
        if (!$this->check()){
            return null;
        }
        $this->sessionStart();
        $user_id = $_SESSION['user_id'];

        return User::getById($user_id);
    }

    private function sessionStart():void
    {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
    public function login(string $login, string $password):bool
    {
        $user = User::getByLogin($login);

        if(($user!==null) and password_verify($password,$user->getPassword())) {
            $this->sessionStart();
            $_SESSION['user_id'] = $user->getId();
            return true;
        }
        return false;


    }

}