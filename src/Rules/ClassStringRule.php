<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class ClassStringRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $is_sub_of = empty($arguments) || !Str::of($arguments[0]) ?
            fn() => true :
            fn() => is_subclass_of($value, $arguments[0]);
        return Str::of($value) && class_exists($value) && $is_sub_of();
    }
}