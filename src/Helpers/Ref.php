<?php

namespace Validationable\Helpers;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionParameter;

class Ref
{
    /**
     * @throws ReflectionException
     */
    public static function isCallableWithArgs(string $callable, array $args): bool
    {
        $reflection = match (true) {
            class_exists($callable) => new ReflectionClass($callable),
            str_contains($callable, '::') => new ReflectionMethod($callable),
            default => new ReflectionFunction($callable)
        };
        $params = Arr::mapWithKeys(
            ($reflection instanceof ReflectionClass ? $reflection->getConstructor() : $reflection)->getParameters(),
            fn(ReflectionParameter $param) => [$param->getName(), $param]);
        if (count(Arr::keyDiff($args, $params)) > 0) {
            return false;
        }
        $values = Arr::mapWithKeys($params, fn($param, $key) => [$param->getName(), match (true) {
            array_key_exists($key, $args) => $args[$key],
            $param->isOptional() => $param->getDefaultValue(),
            $param->allowsNull() => null,
            default => throw new InvalidArgumentException("Missing argument: $key"),
        }]);
        match(get_class($reflection)) {
            ReflectionClass::class => $reflection->newInstanceArgs($values),
            ReflectionMethod::class => $reflection->invokeArgs(null, $values),
            ReflectionFunction::class => $reflection->invokeArgs($values),
        };
        return true;
    }
}