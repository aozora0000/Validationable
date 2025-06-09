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
        if(empty($arguments)) {
            return false;
        }
        if(!Arr::every($arguments, fn ($val) => Str::isInteger($val))) {
            throw new \InvalidArgumentException("Length rule requires integer arguments.");
        }
        if(count($arguments) === 1) {
            $length = Str::of($value) ? mb_strlen($value) : count($value);
            return $length === (int)min($arguments);
        }
        $min = min($arguments);
        $max = max($arguments);
        $length = Str::of($value) ? mb_strlen($value) : count($value);
        return $min <=$length && $length <= $max;
    }
}