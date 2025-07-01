<?php

namespace Validationable\Rules;

use DateTime;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class DatetimeRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        try {
            return match(true) {
                $value === null => false,
                is_a($value, DateTime::class, true) => true,
                Str::of($value) && strtotime($value) !== false => true,
                default => new Datetime($value),
            };
        } catch (\Throwable) {
            return false;
        }
    }
}