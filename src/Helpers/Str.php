<?php

namespace Validationable\Helpers;

use Stringable;

final class Str
{
    public static function rand(): string
    {
        return md5(uniqid(rand(), true));
    }

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

    public static function empty($value): bool
    {
        return !Str::of($value) || $value === '';
    }

    public static function contains($value, string $needle): bool
    {
        return Str::of($value) && str_contains($value, $needle);
    }

    public static function split($value, string $delimiter): array
    {
        return Str::of($value) ? explode($delimiter, $value) : [];
    }

    public static function match($value, string $pattern): bool
    {
        return Str::of($value) && preg_match($pattern, $value);
    }

    public static function startsWith($value, string $needle): bool
    {
        return Str::of($value) && str_starts_with($value, $needle);
    }

    public static function endsWith($value, string $needle): bool
    {
        return Str::of($value) && str_ends_with($value, $needle);
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

    public static function isRegexPattern($value): bool
    {
        if(!Str::of($value)) {
            return false;
        }
        try {
            if(preg_match('/^(.)(.*)\\1[imsxuADSUXJu]*$/', $value)) {
                // 正規表現として利用可能か試す
                set_error_handler(function(): void {}, E_WARNING);
                $result = preg_match($value, "");
                restore_error_handler();
                return $result !== false;
            }
            return false;
        } catch (\Throwable) {
            return false;
        }
    }
}