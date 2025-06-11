<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class TimeZoneRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $arguments = array_map('strtolower', array_merge($arguments ?? [], timezone_identifiers_list()));
        if (!Str::of($value)) {
            return false;
        }
        return in_array(strtolower($value), $arguments, true);
    }
}