<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;

class ObjectRule implements RuleInterface
{
    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        $value = Arr::get($parameters->toArray(), $attribute);
        if ($value === null) {
            return false;
        }
        $class = $arguments[0] ?? 'stdClass';
        $is_sub_class = (boolean)($arguments[1] ?? false);
        return ($is_sub_class ? 'is_subclass_of' : 'is_a')($value, $class, false);
    }
}