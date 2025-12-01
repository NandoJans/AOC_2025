<?php

namespace core;

use ReflectionClass;

class Autowire
{
    public static function start(string $class): string|null|object
    {
        if (!class_exists($class)) {
            return null;
        }

        try {
            $reflection = new ReflectionClass($class);
        } catch (\ReflectionException $e) {
            return null;
        }

        // Get constructor parameters
        $constructor = $reflection->getConstructor();

        // If there is no constructor, instantiate the class
        if (!$constructor) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        // For each parameter, instantiate the class and inject it into the constructor
        return $reflection->newInstanceArgs(array_map(
            fn($param) => Autowire::start($param->getType()->getName()), $parameters
        ));
    }
}