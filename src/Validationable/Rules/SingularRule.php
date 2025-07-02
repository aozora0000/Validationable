<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Inflector;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class SingularRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value)) {
            return false;
        }

        return Inflector::get($arguments[0] ?? 'en')->singularize($value) !== (string)$value;
    }
}