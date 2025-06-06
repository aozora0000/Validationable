<?php

namespace Validationable\Rules;

use Validationable\Parameters;
use Validationable\Str;

class AlphaNumRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Str::match($value, '/^[a-zA-Z0-9]+$/');
    }
}