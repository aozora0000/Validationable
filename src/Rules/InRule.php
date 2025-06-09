<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class InRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (empty($arguments)) {
            throw new \InvalidArgumentException("In rule requires arguments.");
        }

        return Str::of($value) && in_array($value, $arguments, false);
    }
}