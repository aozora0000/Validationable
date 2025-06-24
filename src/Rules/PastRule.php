<?php

namespace Validationable\Rules;

use DateTime;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class PastRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $target = new DateTime($arguments[0] ?? 'now');
        return match (true) {
            $value === null => false,
            is_a($value, DateTime::class, true) => $value < new DateTime($target),
            Str::of($value) && strtotime($value) !== false => $value < new DateTime($target),
            default => false,
        };
    }
}