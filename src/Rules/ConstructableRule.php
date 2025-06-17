<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class ConstructableRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments)) {
            throw new \InvalidArgumentException("ConstructableRule rule requires at least one argument");
        }
        if(!Arr::of($value)) {
            return false;
        }
        if(!Str::of($arguments[0]) || !class_exists($arguments[0])) {
            throw new \InvalidArgumentException("ConstructableRule rule requires a valid class name");
        }
        try {
            $reflection = new \ReflectionClass($arguments[0]);
            $constructor = $reflection->getConstructor();
            if ($constructor === null) {
                return false;
            }

            $params = $constructor->getParameters();
            $paramNames = array_map(fn(\ReflectionParameter $param) => $param->getName(), $params);
            if (count(array_diff(array_keys($value), $paramNames)) > 0) {
                return false;
            }

            $values = [];
            foreach ($params as $param) {
                $paramName = $param->getName();
                $values[$paramName] = match (true) {
                    array_key_exists($paramName, $value) => $value[$paramName],
                    $param->isOptional() => $param->getDefaultValue(),
                    $param->allowsNull() => null,
                    default => throw new \InvalidArgumentException("ConstructableRule rule requires a valid class name"),
                };
            }
            $reflection->newInstanceArgs($values);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}