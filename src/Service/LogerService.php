<?php

namespace Service;

class LogerService
{
    public function record($exception)
    {
        $filename = './../Storage/Log/error.txt';

        $message= $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();

        $datetime= date("Y-m-d H:i:s");

        $errorMessage = "Ошибка: $message\nФайл: $file\nСтрока: $line\nВремя: $datetime\n\n";
        file_put_contents($filename, $errorMessage,FILE_APPEND);

    }
}