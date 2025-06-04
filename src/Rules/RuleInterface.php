<?php

namespace Validationable\Rules;

use Validationable\Parameters;

interface RuleInterface
{
    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool;
}