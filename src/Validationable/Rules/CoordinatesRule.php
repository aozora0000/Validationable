<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 座標(lat,lon)の形式と範囲を検証
 */
class CoordinatesRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $s = (string)$value;
        $parts = array_map('trim', explode(',', $s));
        if (count($parts) !== 2) {
            return false;
        }

        if (!is_numeric($parts[0]) || !is_numeric($parts[1])) {
            return false;
        }

        $lat = (float)$parts[0];
        $lon = (float)$parts[1];
        if ($lat < -90 || $lat > 90) {
            return false;
        }
        return $lon >= -180 && $lon <= 180;
    }
}
