<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class InstanceOfRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments)) {
            throw new \InvalidArgumentException("InstanceOf rule requires arguments.");
        }
        $class = Arr::get($arguments, 0);
        $is_sub_class = (bool)Arr::get($arguments, 1, false);
        return ($is_sub_class ? 'is_subclass_of' : 'is_a')($value, $class, false);
    }
}