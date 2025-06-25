<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class ColorRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value)) {
            return false;
        }

        // HEXカラーコードの検証
        if (Str::startsWith($value, '#')) {
            return Str::match($value, '/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/');
        }

        // RGB, RGBA形式の検証
        if (Str::startsWith($value, 'rgb')) {
            return Str::match($value,'/^rgba?\(\s*\d+\s*,\s*\d+\s*,\s*\d+\s*(?:,\s*(?:0?\.\d+|1(?:\.0)?))?\s*\)$/');
        }

        // HSL, HSLA形式の検証
        if (Str::startsWith($value, 'hsl')) {
            return Str::match($value,'/^hsla?\(\s*\d+\s*,\s*\d+%\s*,\s*\d+%\s*(?:,\s*(?:0?\.\d+|1(?:\.0)?))?\s*\)$/');
        }

        return false;
    }
}