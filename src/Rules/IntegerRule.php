<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class IntegerRule implements RuleInterface
{
    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        $value = Arr::get($parameters->toArray(), $attribute, '');
        $check = fn($val) => preg_match('/^(-|)\d+$/', (string)$val);
        if(str_contains($attribute, '*')) {
            return Arr::every($value, $check);
        }
        return Str::of($value) ? $check($value) : false;
    }
}