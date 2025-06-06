<?php

namespace Validationable\Rules;

use Validationable\Parameters;
use Validationable\Str;

class ClassMethodStringRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $sep = $arguments[0] ?? '@';
        return Str::of($value) && Str::isClassMethodString($attribute, $sep);
    }
}