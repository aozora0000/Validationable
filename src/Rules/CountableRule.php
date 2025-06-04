<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class CountableRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        return is_countable(Arr::get($parameters->toArray(), $attribute));
    }
}