<?php

namespace Validationable\Helpers;

final class Airports
{
    public static function read(): array
    {
        static $items;
        if ($items === null) {
            $items = json_decode(file_get_contents(__DIR__ . '/../../../airports.json'), true);
        }

        return $items;
    }
    
    public static function findByIcao(string $code): ?array
    {
        if(array_key_exists(strtoupper($code), self::read())) {
            return self::read()[strtoupper($code)];
        }

        return null;
    }
    
}