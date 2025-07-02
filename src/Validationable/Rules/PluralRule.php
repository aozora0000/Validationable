<?php

namespace Validationable\Rules;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class PluralRule implements RuleInterface
{
    /**
     * @var array<string, Inflector>
     */
    protected static array $inflectors = [];

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value)) {
            return false;
        }

        $lang = $this->getLang($arguments[0] ?? 'en');
        if (!array_key_exists($lang, static::$inflectors)) {
            static::$inflectors[$lang] = InflectorFactory::createForLanguage($lang)->build();
        }

        return static::$inflectors[$lang]->singularize($value) !== (string)$value;
    }

    public function getLang(string $lang): string
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