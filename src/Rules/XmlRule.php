<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

/**
 * The value must be a valid XML string.
 */
class XmlRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        libxml_use_internal_errors(true);

        $result = simplexml_load_string($value) !== false;

        libxml_clear_errors();

        return $result;
    }
}
