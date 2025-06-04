<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class BetweenRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        if(!(new IntegerRule())->passes($attribute, $parameters)) {
            return false;
        }
        if(Arr::has($arguments, 0) && Arr::has($arguments, 1)) {
            $value = (int)Arr::get($parameters, $attribute);
            $min = (int)min(...$arguments);
            $max = (int)max(...$arguments);
            return $min <= $value && $value <= $max;
        }
        return false;
    }
}