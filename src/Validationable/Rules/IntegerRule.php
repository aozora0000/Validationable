<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class IntegerRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Str::isInteger($value);
    }
}