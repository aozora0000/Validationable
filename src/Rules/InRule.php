<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class InRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments)) {
            throw new \InvalidArgumentException("In rule requires arguments.");
        }

        $value = Arr::get($parameters->toArray(), $attribute, '');
        return Str::of($value) && in_array($value, $arguments, false);
    }
}