<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class NumericRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        $value = Arr::get($parameters->toArray(), $attribute, '');
        $check = fn($val) => preg_match('/^-?\d*\.?\d+$/', $val);
        if(str_contains($attribute, '*')) {
            return Arr::every($value, $check);
        }
        if(is_bool($value)) {
            return false;
        }
        return Str::of($value) && preg_match('/^-?\d*\.?\d+$/', $value);
    }
}