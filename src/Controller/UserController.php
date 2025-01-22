<?php

namespace Controller;
use model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController
{

    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
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

            $user = $this->userModel->getByLogin($login);

            if (!$user) {
                $error['login'] = 'логин или пароль указаны неверно';
            } else {
                $passwordFromDb = $user->getPassword();

                if (password_verify($password, $passwordFromDb)) {
                    // setcookie('user_id', $data['id']);
                    session_start();
                    $_SESSION['user_id'] = $user->getId();
                    header("Location: /catalog");
                } else {
                    $error ['login'] = 'логин или пароль указаны неверно';
                }
            }
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