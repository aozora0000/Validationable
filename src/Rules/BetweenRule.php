<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class BetweenRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::isInteger($value)) {
            return false;
        }
        if(empty($arguments) || !Arr::every($arguments, [Str::class, 'isInteger'])) {
            throw new \InvalidArgumentException('The between rule requires at least 1 argument.');
        }
        $min = (int)min($arguments);
        $max = (int)max($arguments);
        return match(true) {
            Arr::has($arguments, 0) && Arr::has($arguments, 1) => $min <= $value && $value <= $max,
            Arr::has($arguments, 0) => $min <= $value,
            Arr::has($arguments, 1) => $value <= $max,
        };
    }
}