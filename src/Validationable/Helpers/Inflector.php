<?php

namespace Validationable\Helpers;

use Doctrine\Inflector\InflectorFactory;

class Inflector
{
    /**
     * @var array<string, \Doctrine\Inflector\Inflector>
     */
    protected static array $inflectors = [];

    public static function get(string $lang): \Doctrine\Inflector\Inflector
    {
        if (!isset(self::$inflectors[$lang])) {
            self::$inflectors[$lang] = InflectorFactory::create()->build();
        }

        return self::$inflectors[$lang];
    }

    public static function getLang(string $lang): string
    {
        $languages = [
            'english',
            'french',
            'norwegian-bokmal',
            'portuguese',
            'spanish',
            'turkish',
        ];
        foreach ($languages as $language) {
            if (Str::startsWith($language, $lang)) {
                return $language;
            }
        }

        throw new \InvalidArgumentException('Invalid language');
    }
}