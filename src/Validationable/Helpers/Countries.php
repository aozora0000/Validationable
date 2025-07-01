<?php

namespace Validationable\Helpers;

use Flow\ArrayDot\Exception\InvalidPathException;
use function Flow\ArrayDot\array_dot_get;

class Countries
{
    public static function findByCountryCode(string $code): ?array
    {
        return self::where('country.code', fn($value) => strtolower($value) === strtolower($code));
    }

    /**
     * @throws InvalidPathException
     */
    public static function where(string $key, callable $callback): ?array
    {
        foreach (self::read() as $item) {
            if (array_dot_get($item, $key) !== '' && $callback(array_dot_get($item, $key))) {
                return $item;
            }
        }
        return null;
    }

    public static function read(): array
    {
        static $items;
        if ($items === null) {
            $items = json_decode(file_get_contents(__DIR__ . '/../../../locales.json'), true);
        }
        return $items;
    }

    public static function findByLocale(string $locale): ?array
    {
        return self::where('locale', fn($value) => strtolower($value) === strtolower(str_replace('_', '-', $locale)));
    }

    public static function findByCurrency(string $currency): ?array
    {
        return self::where('country.currency_code', fn($value) => strtolower($value) === strtolower($currency));
    }
}
