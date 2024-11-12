<?php

$pdo = new PDO("pgsql:host=db; port=5432; dbname=mydb", 'user', 'pass');
$pdo->exec("CREATE TABLE users (id SERIAL PRIMARY KEY , name varchar(255) not null)");
print_r($pdo);
$conn = pg_connect("host=postgres_db dbname=mydb user=user password=pass");
if ($conn) {
    echo "Connected to PostgreSQL successfully!";
} else {
    echo "Connection failed.";
}

