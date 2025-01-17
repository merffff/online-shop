<?php

namespace Core;

class Autoload
{
    public static function registrate (string $rootPath)
    {
        $autoload =  function ($className) use ($rootPath) {
            $handlerPath = str_replace('\\','/', $className);
            $path = $rootPath .'/'. $handlerPath . '.php';
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };

        spl_autoload_register($autoload);
    }

}