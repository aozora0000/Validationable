<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class SlugRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!is_string($value) || $value === '') {
            return false;
        }

        return Str::match($value, '/^[a-z0-9]+(?:-[a-z0-9]+)*$/');
    }
}
