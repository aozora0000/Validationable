<?php

namespace Validationable\Rules;

use Validationable\Parameters;
use Validationable\Str;

class RegexRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Str::of($value) && Str::isRegexPattern($value);
    }
}