<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class ClosureRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        if(!Arr::has($parameters->toArray(), $attribute)) {
            return false;
        }
        $value = Arr::get($parameters->toArray(), $attribute);
        return match(true) {
            is_callable($value) => true,
            $value instanceof \Closure => true,
            is_object($value) && method_exists($value, '__invoke') => true,
            default => false,
        };
    }
}