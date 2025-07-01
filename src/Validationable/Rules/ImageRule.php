<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class ImageRule implements RuleInterface
{

    public static array $allowedMimeTypes = [
        'jpeg',
        'jpg',
        'png',
        'gif',
        'webp',
        'bmp',
        'svg',
        'avif'
    ];

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $rule = new MimesRule();
        return $rule->passes($attribute, $value, $parameters, self::$allowedMimeTypes);
    }
}