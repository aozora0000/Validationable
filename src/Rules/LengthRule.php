<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class LengthRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if ($arguments === []) {
            return false;
        }

        if (!Arr::every($arguments, fn($val): bool => Str::isInteger($val))) {
            throw new \InvalidArgumentException("Length rule requires integer arguments.");
        }

        $length = Str::of($value) ? mb_strlen($value) : count($value);
        if (count($arguments) === 1) {
            return $length === (int)min($arguments);
        }

        return min($arguments) <= $length && $length <= max($arguments);
    }
}