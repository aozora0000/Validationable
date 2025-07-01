<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Countries;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class CountryCodeRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Str::of($value) && Countries::findByCountryCode($value) !== null;
    }
}