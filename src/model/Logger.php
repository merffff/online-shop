<?php

namespace model;

class Logger extends Model
{
    public function log(string $type, \Throwable $exception)
    {
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        $datetime= date("Y-m-d H:i:s");
        $stmt = self::getPdo()->prepare("INSERT INTO logs (type, message, line, file, datetime) VALUES (:type, :message, :line, :file, :datetime) ");
        $stmt->execute([
            ':type'=>$type,
            ':message'=>$message,
            ':line'=>$line,
            ':file'=>$file,
            ':datetime'=>$datetime
            ]);
    }

}