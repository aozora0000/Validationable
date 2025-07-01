<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class MacAddressRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_MAC) !== false;
    }
}
