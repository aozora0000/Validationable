<?php

namespace Validationable\Rules;

use Validationable\Parameters;

interface RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool;
}