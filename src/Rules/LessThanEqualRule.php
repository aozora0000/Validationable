<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class LessThanEqualRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        if(!(new IntegerRule())->passes($attribute, $parameters)) {
            return false;
        }
        if(Arr::has($arguments, 0)) {
            $value = (int)Arr::get($parameters, $attribute);
            return $value <= (int)$arguments[0];
        }
        return false;
    }
}