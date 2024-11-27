<?php

function validateRegistrationForm(array $arrPost): array
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
            $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $data = $stmt->fetch();

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

$error = validateRegistrationForm($_POST);





//print_r($name);
//print_r($email);
//print_r($password);
//print_r($passwordRep);
if (empty($error)) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $passwordRep = $_POST['passwordRep'];

    $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO users (name, email,login, password) VALUES (:name, :email,:login,:password)");

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute(['name' => $name, 'email' => $email, 'login' => $login, 'password' => $hash]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    header("Location: /login");

    //print_r($stmt->fetch());
} else {

    require_once './get_registration.php';
}


