<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class StringRule implements RuleInterface
{
    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        return is_string(Arr::get($parameters->toArray(), $attribute));
    }
}