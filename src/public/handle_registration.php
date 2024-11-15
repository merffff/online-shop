<?php

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordRep = $_POST['passwordRep'];


$error = [];
if (isset($_POST['name'])) {
    $name = $_POST['name'];

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


if (isset($_POST['email'])) {
    $email = $_POST['email'];

    if (empty($email)) {
        $error['email'] = 'email не может быть пустым';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error['email'] = 'email указан неверно';
    }
} else {
    $error['email'] = 'email is required';
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];

    if (empty($password)) {
        $error['password'] = 'пароль не может быть пустым';
    } elseif (strlen($email) < 8) {
        $error['password'] = 'пароль должен содержать не менее 8 символов';
    } elseif (is_numeric($password)) {
        $error['password'] = 'пароль не должен содержать только цифры';
    }
} else {
    $error['password'] = 'password is required';
}

if (isset($_POST['passwordRep'])) {
    $passwordRep = $_POST['passwordRep'];

    if (empty($passwordRep)) {
        $error['passwordRep'] = 'поле не должно быть пустым';
    } elseif ($passwordRep !== $password) {
        $error['passwordRep'] = 'пароль не совпадает';
    }
} else {
    $error['passwordRep'] = 'repeat password is required';
}





//print_r($name);
//print_r($email);
//print_r($password);
//print_r($passwordRep);
if (empty($error)) {
    $pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email,:password)");

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    print_r($stmt->fetch());
} else {

    require_once './get_registration.php';
}
?>

