<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class PortNumberRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!is_numeric($value) || (int)$value != $value) {
            return false;
        }

        $port = (int)$value;
        return ($port >= 1 && $port <= 65535);
    }
}
