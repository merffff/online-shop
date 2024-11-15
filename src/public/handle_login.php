<?php

$login = $_POST['login'];
$password = $_POST['password'];

$error=[];

if (isset($_POST['login'])) {
$login = $_POST['login'];

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

if (isset($_POST['password'])) {
    $password = $_POST['password'];

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

if (empty($error)) {
    $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");

    $stmt->execute(['login' => $login]);

    $data = $stmt->fetch();

    if ($data === false) {
        $error['login'] = 'не существует пользователя с указанным логином';
    } else {
        $passwordFromDb = $data['password'];

        if (password_verify($password, $passwordFromDb)) {
            echo 'ok!';
        } else {
            $error ['password'] = 'неверный пароль';
        }
    }
}

    require_once './get_login.php';
