<?php

namespace Validationable;

use ArrayAccess;
use Flow\ArrayDot\Exception\InvalidPathException;
use Validationable\Rules\RuleInterface;
use function Flow\ArrayDot\array_dot_get;
use function Flow\ArrayDot\array_dot_set;

class Arr
{
    public static function toArray($value): array
    {
        return match(true) {
            is_a($value, \IteratorIterator::class) => iterator_to_array($value),
            is_a($value, '\Illuminate\Support\Collection') => $value->toArray(),
            is_a($value, 'Illuminate\Contracts\Support\Arrayable') => $value->toArray(),
            is_a($value, ArrayAccess::class) => (array)$value,
            is_array($value) => $value,
            default => [$value],
        };
    }

    public static function of($value): bool
    {
        return match(true) {
            is_a($value, \IteratorIterator::class) => true,
            is_a($value, '\Illuminate\Support\Collection') => true,
            is_a($value, 'Illuminate\Contracts\Support\Arrayable') => true,
            is_a($value, ArrayAccess::class) => true,
            is_array($value) => true,
            default => false,
        };
    }

    public static function dot($array, string $prepend = ''): array
    {
        try {
            return array_dot_get($array, $prepend);
        } catch (\Throwable) {
            return [];
        }
    }

    public static function has($array, string $prepend = ''): bool
    {
        try {
            array_dot_get($array, $prepend);
            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    public static function get($array, string $prepend = '', mixed $default = null)
    {
        try {
            return array_dot_get($array, $prepend);
        } catch (\Throwable) {
            return $default;
        }
    }

    /**
     * @throws InvalidPathException
     */
    public static function set(&$array, string $prepend, mixed $value): void
    {
        array_dot_set($array, $prepend, $value);
    }

    /**
     * @throws InvalidPathException
     */
    public static function forget(&$array, string $prepend): void
    {
        array_dot_set($array, $prepend, null);
    }

    public static function every($array, callable $callback): bool
    {
        foreach ($array as $key => $value) {
            if (! $callback($value, $key)) {
                return false;
            }
        }
        return true;
    }

    public static function some($array, callable $callback): bool
    {
        foreach ($array as $key => $value) {
            if ($callback($value, $key)) {
                return true;
            }
        }
        return false;
    }

    public static function everyPasses(array $array, string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Arr::every($array, fn(RuleInterface $rule) => $rule->passes($attribute, $value, $parameters, $arguments));
    }

    public static function somePasses(array $array, string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return Arr::some($array, fn(RuleInterface $rule) => $rule->passes($attribute, $value, $parameters, $arguments));
    }

    public static function countable($array): bool
    {
        return is_countable($array);
    }

    public static function findByValue($array, $value, $default = null)
    {
        if(array_search($value, $array, true) === -1) {
            return $default;
        }
        return $array[array_search($value, $array, true)];
    }
}