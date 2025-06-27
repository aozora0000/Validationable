<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Airports;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class IcaoRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Str::of($value) && Airports::findByIcao($value) !== null;
    }
}