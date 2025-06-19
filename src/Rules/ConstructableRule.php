<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\Ref;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class ConstructableRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if($arguments === []) {
            throw new \InvalidArgumentException("ConstructableRule rule requires at least one argument");
        }

        if(!Arr::of($value)) {
            return false;
        }

        if(!Str::of($arguments[0]) || !class_exists($arguments[0])) {
            throw new \InvalidArgumentException("ConstructableRule rule requires a valid class name");
        }

        try {
            return Ref::isCallableWithArgs($arguments[0], $value);
        } catch (\Throwable $e) {
            return false;
        }
    }
}