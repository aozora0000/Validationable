<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class RequiredRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        $value = Arr::get($parameters->toArray(), $attribute, '');
        $check = fn ($val) => match($val) {
            null, '', [] => false,
            default => true,
        };
        return Str::isGlob($attribute) ? Arr::every($value, $check) : $check($value);
    }
}