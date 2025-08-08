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

    // IATAコードで空港情報を検索する
    public static function findByIata(string $code): ?array
    {
        $code = strtoupper($code);
        foreach (self::read() as $airport) {
            // airports.jsonの各要素は配列で、'iata'キーにIATAコードが入る（空文字の場合もある）
            if (($airport['iata'] ?? '') === $code && $code !== '') {
                return $airport;
            }
        }

        return null;
    }
    
}