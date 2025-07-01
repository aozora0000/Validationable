<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class IsbnRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(!Str::of($value)) {
            return false;
        }
        // 区切り文字を削除して正規化
        $isbn = preg_replace('/[^0-9X]/', '', $value);

        // ISBN-10の検証
        if (strlen($isbn) === 10) {
            $sum = 0;
            for ($i = 0; $i < 9; $i++) {
                $sum += (int)$isbn[$i] * (10 - $i);
            }

            $checkDigit = ($isbn[9] === 'X') ? 10 : (int)$isbn[9];
            $sum += $checkDigit;

            return $sum % 11 === 0;
        }

        // ISBN-13の検証
        if (strlen($isbn) === 13) {
            $sum = 0;
            for ($i = 0; $i < 12; $i++) {
                $sum += (int)$isbn[$i] * (($i % 2 === 0) ? 1 : 3);
            }

            $checkDigit = 10 - ($sum % 10);
            if ($checkDigit === 10) {
                $checkDigit = 0;
            }

            return (int)$isbn[12] === $checkDigit;
        }

        return false;
    }
}