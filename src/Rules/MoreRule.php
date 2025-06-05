<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class MoreRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(!(new IntegerRule())->passes($attribute,$value, $parameters)) {
            return false;
        }
        if(Arr::has($arguments, 0)) {
            return Str::of($value) && $arguments[0] < $value;
        }
        return false;
    }
}