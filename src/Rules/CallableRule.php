<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class CallableRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments)) {
            throw new \InvalidArgumentException("CallableRule rule requires at least one argument");
        }
        if(!Arr::of($value)) {
            return false;
        }
        if(!Str::of($arguments[0]) || !(Str::isClassMethodString($arguments[0], '::') || function_exists($arguments[0]))) {
            throw new \InvalidArgumentException("CallableRule rule requires a valid class name");
        }
        try {
            $reflection = match (true) {
                str_contains($arguments[0], '::') => new \ReflectionMethod($arguments[0]),
                default => new \ReflectionFunction($arguments[0])
            };

            $params = $reflection->getParameters();
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
                    default => throw new \InvalidArgumentException(sprintf("CallableRule rule requires a valid function name [%s]", $paramName)),
                };
            }
            match(get_class($reflection)) {
                \ReflectionMethod::class => $reflection->invokeArgs(null, $values),
                \ReflectionFunction::class => $reflection->invokeArgs($values),
            };
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}