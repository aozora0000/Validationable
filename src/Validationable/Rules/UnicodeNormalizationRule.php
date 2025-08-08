<?php

namespace Validationable\Rules;

use Normalizer;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * Unicode正規化(NFC)済みかを検証するルール
 * - 文字列以外はfalse
 * - 空文字はfalse
 * - Normalizer::isNormalized(FORM_C) がtrueの場合にtrue
 */
class UnicodeNormalizationRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false; // 文字列以外や空は不可
        }

        // intl拡張のNormalizerが利用可能か確認
        if (!class_exists(Normalizer::class)) {
            // 利用不可の場合は安全側にfalse
            return false;
        }

        return Normalizer::isNormalized((string)$value, Normalizer::FORM_C);
    }
}
