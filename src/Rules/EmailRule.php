<?php

namespace Validationable\Rules;

use Validationable\Arr;
use Validationable\Parameters;
use Validationable\Str;

class EmailRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(!Str::contains($value, '@')) {
            return false;
        }

        [, $host] = Str::split($value, '@');
        if(Str::empty($host)) {
            return false;
        }

        $callback = fn(string $type): bool => checkdnsrr($host, $type);
        return
            filter_var($value, FILTER_VALIDATE_EMAIL) !== false &&
            Arr::some(['MX', 'A', 'AAAA'], $callback);
    }
}