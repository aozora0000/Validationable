<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 半角のみで構成されるかを検証（簡易: 文字幅=1の文字のみ）
 */
class HankakuRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $s = (string)$value;
        return mb_strwidth($s, 'UTF-8') === mb_strlen($s, 'UTF-8');
    }
}
