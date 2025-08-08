<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 仮名（ひらがな or カタカナ）のみで構成されるかを検証
 */
class KanaRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $s = (string)$value;
        // ひらがな: 3040-309F, カタカナ: 30A0-30FF, 長音符: 30FC, スペース許容
        return (bool)preg_match('/^[\x{3040}-\x{309F}\x{30A0}-\x{30FF}ー\s]+$/u', $s);
    }
}
