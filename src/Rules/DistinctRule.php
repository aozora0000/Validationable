<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Parameters;

class DistinctRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Arr::of($value) && count($value) === count(array_unique($value));
    }
}