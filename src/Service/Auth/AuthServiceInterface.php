<?php

namespace Service\Auth;

use model\User;

interface AuthServiceInterface
{
    public function check():bool;
    public function getCurrentUser(): ?User;

    public function login(string $login, string $password):bool;

}