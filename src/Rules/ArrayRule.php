<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class ArrayRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Arr::of($value);
    }
}