<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 郵便番号（日本）: 123-4567 または 1234567
 */
class PostalCodeRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $s = (string)$value;
        return (bool)preg_match('/^(\d{3}-\d{4}|\d{7})$/', $s);
    }
}
