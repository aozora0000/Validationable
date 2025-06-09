<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class ClassMethodStringRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $sep = $arguments[0] ?? '@';
        return Str::of($value) && Str::isClassMethodString($attribute, $sep);
    }
}