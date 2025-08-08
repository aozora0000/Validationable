<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 全角のみで構成されるかを検証（簡易: 全幅=2の文字のみ）
 */
class ZenkakuRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $s = (string)$value;
        // すべての文字が全角であるか（幅2）を確認
        return mb_strwidth($s, 'UTF-8') === (mb_strlen($s, 'UTF-8') * 2);
    }
}
