<?php

namespace Validationable;

use Stringable;

class Str
{
    public static function isInteger($value): bool
    {
        return Str::of($value) && preg_match('/^(-|)\d+$/', $value);
    }

    public static function of($value): bool
    {
        return match (true) {
            is_string($value), is_float($value), is_int($value), is_bool($value) && is_a($value, Stringable::class) => true,
            default => false,
        };
    }

    public static function isNumeric($value): bool
    {
        return Str::of($value) && is_numeric($value);
    }

    public static function isBoolean($value): bool
    {
        return in_array($value, ['true', 'false', 'TRUE', 'FALSE', 'True', 'False', '1', '0', true, false, 1, 0], true);
    }

    public static function isGlob(string $value): bool
    {
        return Str::of($value) && str_contains($value, '*');
    }

    public static function isClassString($value, string $class): bool
    {
        return Str::of($value) && is_a($value, $class, true);
    }

    public static function isClassMethodString($value, string $sep): bool
    {
        if (Str::of($value) && str_contains($value, $sep)) {
            [$class, $method] = explode($sep, $value);
            return class_exists($class) && method_exists($class, $method);
        }
        return false;
    }
}