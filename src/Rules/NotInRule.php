<?php

namespace Validationable\Rules;

use Validationable\Parameters;

class NotInRule implements RuleInterface
{

    public function passes(string $attribute, Parameters $parameters, array $arguments = []): bool
    {
        return !(new InRule)->passes($attribute, $parameters, $arguments);
    }
}