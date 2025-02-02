<?php

namespace Controller;
use model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Service\AuthService;

class UserController
{

    private User $userModel;
    private AuthService $authService;

    public function __construct()
    {
        $this->userModel = new User();
        $this->authService = new AuthService();
    }



    public function getRegistrateForm()
    {
        require_once './../view/registrate.php';
    }
    public function registrate(RegistrateRequest $request)
    {
        $error = $request->validate();

        if (empty($error)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $login = $request->getlogin();
            $password = $request->getPassword();
            $passwordRep = $request->getPasswordRep();
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->create($name, $email, $login, $hash);

            header("Location: /login");


        } else {

            require_once './../view/registrate.php';
        }

    }


    public function getLoginForm()
    {
        require_once './../view/login.php';
    }

    public function login(LoginRequest $request)
    {
        $error = $request->validate();

        if (empty($error)) {
            $login = $request->getlogin();
            $password = $request->getPassword();

            if ($this->authService->login($login,$password) === false) {
                $error['login'] = 'логин или пароль указаны неверно';
            }
            header("Location: /catalog");

        }

        require_once './../view/login.php';


    }


    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        header("Location: /login");
    }


}