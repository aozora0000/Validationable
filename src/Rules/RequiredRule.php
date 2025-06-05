<?php

namespace Validationable\Rules;

use Validationable\Parameters;

class RequiredRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return match ($value) {
            null, '', [] => false,
            default => true,
        };
    }
}