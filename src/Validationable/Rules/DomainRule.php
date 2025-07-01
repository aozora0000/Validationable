<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class DomainRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return match(true) {
            !Str::of($value), strlen($value) > 25 => false,
            !filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) => false,
            gethostbyname($value) === $value => false,
            default => true,
        };
    }
}