<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\File;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class ImageRatioRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if ($arguments === []) {
            throw new \InvalidArgumentException("Image width rule requires at least one argument");
        }

        $fraction = Str::split($arguments[0], '/');
        if (count($fraction) !== 2 || !Arr::every($fraction, fn($arg): bool => Str::isNumeric($arg))) {
            throw new \InvalidArgumentException("Image width rule requires a numeric ratio");
        }

        if (!(new ImageRule)->passes($attribute, $value, $parameters, $arguments)) {
            return false;
        }

        return File::imageRatio($value) === (int)$fraction[0] / (int)$fraction[1];
    }
}