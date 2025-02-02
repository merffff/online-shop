<?php

namespace model;
use PDO;

class Model
{
    protected static PDO $pdo;


    public static function getPdo(): PDO
    {
        if(!isset(self::$pdo)) {
            self::$pdo = new PDO ('pgsql:host=db;port=5432;dbname=mydb', 'user', 'pass');
        }

        return self::$pdo;
    }


}