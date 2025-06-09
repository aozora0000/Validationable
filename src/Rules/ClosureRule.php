<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class ClosureRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return match (true) {
            is_callable($value) => true,
            $value instanceof \Closure => true,
            is_object($value) && method_exists($value, '__invoke') => true,
            default => false,
        };
    }
}