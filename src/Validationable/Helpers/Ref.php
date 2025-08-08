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
            str_contains($callable, '::') => new ReflectionMethod(...explode('::', $callable)),
            default => new ReflectionFunction($callable)
        };
        $params = Arr::mapWithKeys(
            ($reflection instanceof ReflectionClass ? $reflection->getConstructor() : $reflection)->getParameters(),
            fn(ReflectionParameter $param): array => [$param->getName(), $param]);
        if (Arr::keyDiff($args, $params) !== []) {
            return false;
        }

        $values = Arr::mapWithKeys($params, fn($param, $key): array => [$param->getName(), match (true) {
            array_key_exists($key, $args) => $args[$key],
            $param->isOptional() => $param->getDefaultValue(),
            $param->allowsNull() => null,
            default => throw new InvalidArgumentException('Missing argument: ' . $key),
        }]);
        match(get_class($reflection)) {
            ReflectionClass::class => $reflection->newInstanceArgs($values),
            ReflectionMethod::class => $reflection->invokeArgs(null, $values),
            ReflectionFunction::class => $reflection->invokeArgs($values),
        };
        return true;
    }
}