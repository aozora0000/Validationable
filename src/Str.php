<?php

namespace Validationable;

use Stringable;

class Str
{
    public static function of($value): bool
    {
        return match(true) {
            is_string($value), is_float($value), is_int($value), is_a($value, Stringable::class) => true,
            default => false,
        };
    }

    public static function isGlob(string $value): bool
    {
        return Str::of($value) && str_contains($value, '*');
    }

    public static function isClassString($value, string $class): bool
    {
        return Str::of($value) && is_a($value, $class, true);
    }
}