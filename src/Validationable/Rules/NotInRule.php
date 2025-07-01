<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Parameters;

class NotInRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return !Arr::everyPasses([new InRule], $attribute, $value, $parameters, $arguments);
    }
}