<?php

namespace Validationable\Helpers;

class Countries
{
    public static function read(): array
    {
        static $items;
        if($items === null) {
            $items = json_decode(file_get_contents(__DIR__ . '/../../locales.json'), true);
        }
        return $items;
    }

    public static function findByCountryCode(string $code): ?array
    {

        foreach(self::read() as $item) {
            if(strtolower($item['country']['code']) === strtolower($code)) {
                return $item;
            }
        }
        return null;
    }

    public static function findByLocale(string $locale): ?array
    {
        foreach(self::read() as $item) {
            if(strtolower($item['locale']) === strtolower(str_replace('_', '-', $locale))) {
                return $item;
            }
        }
        return null;
    }
}
