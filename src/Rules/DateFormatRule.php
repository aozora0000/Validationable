<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class DateFormatRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments) || !Str::of($arguments[0])) {
            throw new \InvalidArgumentException('The date format is required.');
        }
        try {
            if(!Str::of($value)) {
                return false;
            }
            return date_create_from_format($arguments[0], $value) !== false;
        } catch (\Throwable) {
            return false;
        }

    }
}