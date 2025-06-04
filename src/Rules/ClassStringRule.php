<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class ClassStringRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        if((new StringRule)->passes($attribute, $parameters, $arguments)) {
            return class_exists(Arr::get($parameters->toArray(), $attribute));
        }
        return false;
    }
}