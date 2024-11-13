<?php

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];
$passwordRep = $_GET['psw-repeat'];

//print_r($name);
//print_r($email);
//print_r($password);
//print_r($passwordRep);
$pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass' );
$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email','$password')");

$result = $pdo->query("SELECT * FROM users ORDER BY id DESC");
print_r($result->fetch());