<?php

namespace Validationable;

use Validationable\Rules\RuleInterface;

class Rule
{
    public static function callback(callable $callback): RuleInterface
    {
        return new class($callback) implements RuleInterface {
            public function __construct(private $callback) {}
            public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
            {
                return ($this->callback)($attribute, $parameters, $arguments);
            }
        };
    }
}