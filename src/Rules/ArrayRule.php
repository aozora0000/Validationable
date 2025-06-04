<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class ArrayRule implements RuleInterface
{
    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        $value = Arr::get($parameters->toArray(), $attribute);
        $check = fn ($val) => Arr::of($val);
        return Str::isGlob($attribute) ? Arr::every($value, $check) : $check($value);
    }
}