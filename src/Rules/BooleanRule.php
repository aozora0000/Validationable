<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class BooleanRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        return in_array(Arr::get($parameters->toArray(), $attribute), [true, false, 0, 1, '0', '1'], true);
    }
}