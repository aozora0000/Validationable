<?php

namespace Validationable\Rules;

use Validationable\Parameters;

class InstanceOfRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments)) {
            throw new \InvalidArgumentException("InstanceOf rule requires arguments.");
        }
        $class = $arguments[0] ?? 'stdClass';
        $is_sub_class = (boolean)($arguments[1] ?? false);
        return ($is_sub_class ? 'is_subclass_of' : 'is_a')($value, $class, false);
    }
}