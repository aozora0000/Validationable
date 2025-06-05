<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class LengthRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $pass = fn(RuleInterface $rule) => $rule->passes($attribute, $parameters);
        if(!Arr::every([new IntegerRule, new StringRule], $pass)) {
            return false;
        }
        if(!Arr::has($arguments, 0) || !Arr::has($arguments, 1)) {
            return false;
        }

        if(count($arguments) === 1) {
            return Str::of($value) && count($value) === $arguments[0];
        }
        $min = min(...$arguments);
        $max = max(...$arguments);
        return  Str::of($value) && $min <= count($value) && count($value) <= $max;
    }
}