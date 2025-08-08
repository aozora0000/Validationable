<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Airports;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class IataRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        // 文字列でない、または空の場合はfalse
        if (!Str::of($value) || $value === '') {
            return false;
        }

        // IATAコードは通常3文字の英大文字だが、データ基準で存在確認を行う
        return Airports::findByIata($value) !== null;
    }
}
