<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class LengthRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        $pass = fn(RuleInterface $rule) => $rule->passes($attribute, $parameters);
        if(!Arr::every([new IntegerRule, new StringRule], $pass)) {
            return false;
        }
        if(!Arr::has($arguments, 0) || !Arr::has($arguments, 1)) {
            return false;
        }
        if(count($arguments) === 1) {
            return count(Arr::get($parameters->toArray(), $attribute)) === $arguments[0];
        }
        $min = min(...$arguments);
        $max = max(...$arguments);
        $value = Arr::get($parameters->toArray(), $attribute);

        return $min <= count($value) && count($value) <= $max;
    }
}