<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class MoreThanEqualRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments)) {
            throw new \InvalidArgumentException("Less rule requires parameters.");
        }
        $integer = fn ($val) => Str::isNumeric($val);
        if(!Arr::every($arguments, $integer)) {
            throw new \InvalidArgumentException("Less rule requires integer arguments.");
        }
        return $integer($value) && $arguments[0] <= $value;
    }
}