<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class ClassMethodString implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        if(!(new StringRule)->passes($attribute, $parameters, $arguments)) {
            return false;
        }
        $sep = $arguments[0] ?? '@';
        $value = Arr::get($parameters->all(), $attribute);
        if(!str_contains($value, $sep)) {
            return false;
        }
        [$class, $method] = explode($sep, $attribute);

        return class_exists($class) && method_exists($class, $method);
    }
}