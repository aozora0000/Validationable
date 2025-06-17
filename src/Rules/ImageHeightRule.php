<?php

namespace Validationable\Rules;

use Intervention\Image\Image;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\File;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class ImageHeightRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (empty($arguments)) {
            throw new \InvalidArgumentException("Image height rule requires at least one argument");
        }
        if (!preg_match('/\d+$/u', $arguments[0])) {
            throw new \InvalidArgumentException("Image height rule requires a valid size");
        }
        if (!(new ImageRule)->passes($attribute, $value, $parameters, $arguments)) {
            return false;
        }
        $replace = fn(string $arg) => (int)str_replace($arg, '', $arguments[0]);
        $fn = fn(Image $image): bool => match(true) {
            (bool)preg_match('/^\d+$/', $arguments[0]) => $image->height() === (int)$arguments[0],
            Str::startsWith($arguments[0], '==')=> $image->height() === $replace('=='),
            Str::startsWith($arguments[0], '<=') => $image->height() <= $replace('<='),
            Str::startsWith($arguments[0], '<') => $image->height() < $replace('<'),
            Str::startsWith($arguments[0], '>=') => $image->height() >= $replace('>='),
            Str::startsWith($arguments[0], '>') => $image->height() > $replace('>'),
            Str::startsWith($arguments[0], '=')=> $image->height() === $replace('='),
            default => throw new \InvalidArgumentException("Invalid comparison operator"),
        };
        return File::isImageCompare($value, $fn);
    }
}