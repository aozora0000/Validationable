<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class AsciiRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return Str::match($value, '/^[\x00-\x7F]*$/');
    }
}
