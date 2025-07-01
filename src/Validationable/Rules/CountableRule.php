<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class CountableRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return is_countable($value);
    }
}