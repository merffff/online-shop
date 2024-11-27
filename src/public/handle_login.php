<?php

function validateLoginForm(array $arrPost): array
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

$error = validateLoginForm($_POST);

if (empty($error)) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $stmt->execute(['login' => $login]);
    $data = $stmt->fetch();

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

    require_once './get_login.php';
