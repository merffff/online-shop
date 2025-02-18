<?php

namespace Core;

class Container
{
    private array $services = [];
    public function get(string $class): object
    {
        if (!isset($this->services[$class])) {
            return new $class();
        }
        $callback = $this->services[$class];
        return $callback($this);
    }

    public function set(string $class, callable $callback)
    {
        $this->services[$class] = $callback;

    }

}

