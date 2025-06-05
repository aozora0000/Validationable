<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class RequiredIfRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments)) {
            throw new \InvalidArgumentException("RequiredIf rule requires arguments.");
        }
        $rule = new RequiredRule;
        $passes = fn($attr) => $rule->passes($attr, Arr::get($parameters->toArray(), $attr), $parameters);
        if(Arr::every($arguments, $passes)) {
            return $passes($attribute);
        }
        return true;
    }
}