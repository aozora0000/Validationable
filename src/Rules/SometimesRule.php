<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class SometimesRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Arr::has($parameters->toArray(), $attribute);
    }
}