<?php

namespace Validationable\Rules;

use Illuminate\Support\Str;
use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class EqualsRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if ($arguments === []) {
            throw new \InvalidArgumentException("EqualsRule rule requires at least one argument");
        }

        if ($parameters->has($arguments[0])) {
            return Str::of($value) && (string)$value === (string)$parameters->get($arguments[0]);
        }

        return Str::of($value) && (string)$value === (string)$arguments[0];
    }
}