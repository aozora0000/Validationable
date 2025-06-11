<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Parameters;

class ArrayKeysRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Arr::of($value) && Arr::of($arguments) &&
            Arr::every($arguments, fn($key) => in_array($key, $value));
    }
}