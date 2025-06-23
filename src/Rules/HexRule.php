<?php

namespace Validationable\Rules;

use Validationable\Helpers\Str;
use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class HexRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Str::of($value) && ctype_xdigit($value);
    }
}