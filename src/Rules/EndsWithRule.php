<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class EndsWithRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(empty($arguments) || !Arr::every($arguments, fn($arg) => Str::of($arg))) {
            throw new \InvalidArgumentException('The endsWith rule requires at least 1 argument.');
        }
        return Str::of($value) && Arr::some($arguments, fn(string $arg) => Str::endsWith($value, $arg));
    }
}