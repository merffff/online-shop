<?php

namespace Controller;
use model\User;
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
    public function registrate()
    {
        $error = $this->validateRegistrationForm($_POST);

        if (empty($error)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $login = $_POST['login'];
            $password = $_POST['password'];
            $passwordRep = $_POST['passwordRep'];
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->create($name, $email, $login, $hash);

            header("Location: /login");


        } else {

            require_once './../view/registrate.php';
        }

    }

    private function validateRegistrationForm(array $arrPost): array
    {
        $error = [];

        if (isset($arrPost['name'])) {
            $name = $arrPost['name'];

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


        if (isset($arrPost['email'])) {
            $email = $arrPost['email'];

            if (empty($email)) {
                $error['email'] = 'email не может быть пустым';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'email указан неверно';
            } else {

                $data = $this->userModel->getByEmail($email);

                if ($data !== false) {
                    $error['email'] = 'пользователь с указанной почтой существует';
                }
            }
        } else {
            $error['email'] = 'email is required';
        }

        if (isset($arrPost['login'])) {
            $login = $arrPost['login'];

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

        if (isset($arrPost['password'])) {
            $password = $arrPost['password'];

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

        if (isset($arrPost['passwordRep'])) {
            $passwordRep = $arrPost['passwordRep'];

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




    public function getLoginForm()
    {
        require_once './../view/login.php';
    }

    public function login()
    {
        $error = $this-> validateLoginForm($_POST);

        if (empty($error)) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            $data = $this->userModel->getByLogin($login);

            if ($data === false) {
                $error['login'] = 'логин или пароль указаны неверно';
            } else {
                $passwordFromDb = $data['password'];

                if (password_verify($password, $passwordFromDb)) {
                    // setcookie('user_id', $data['id']);
                    session_start();
                    $_SESSION['user_id'] = $data['id'];
                    header("Location: /catalog");
                } else {
                    $error ['login'] = 'логин или пароль указаны неверно';
                }
            }
        }

        require_once './../view/login.php';


    }

    private function validateLoginForm(array $arrPost): array
    {

        $error = [];

        if (isset($arrPost['login'])) {
            $login = $arrPost['login'];

            if (empty($login)) {
                $error['login'] = 'логин не может быть пустым';
            }
        } else {
            $error['login'] = 'login is required';
        }

        if (isset($arrPost['password'])) {
            $password = $arrPost['password'];

            if (empty($password)) {
                $error['password'] = 'пароль не может быть пустым';
            }
        } else {
            $error['password'] = 'password is required';
        }

        return $error;
    }

    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();

        header("Location: /login");
    }


}