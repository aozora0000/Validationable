<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * ひらがなのみで構成されるかを検証
 */
class HiraganaRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $s = (string)$value;
        return (bool)preg_match('/^[\x{3040}-\x{309F}ー\s]+$/u', $s);
    }
}
