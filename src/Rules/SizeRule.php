<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\File;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class SizeRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (empty($arguments)) {
            throw new \InvalidArgumentException("File size rule requires at least one argument");
        }
        if (!preg_match('/\d+$/u', $arguments[0])) {
            throw new \InvalidArgumentException("File size rule requires a valid size");
        }
        if (!(new FileRule)->passes($attribute, $value, $parameters, $arguments)) {
            return false;
        }
        $replace = fn(string $arg) => (int)str_replace($arg, '', $arguments[0]);
        $fn = fn(int $size): bool => match(true) {
            (bool)preg_match('/^\d+$/', $arguments[0]) => $size === (int)$arguments[0],
            Str::startsWith($arguments[0], '==')=> $size === $replace('=='),
            Str::startsWith($arguments[0], '<=') => $size <= $replace('<='),
            Str::startsWith($arguments[0], '<') => $size < $replace('<'),
            Str::startsWith($arguments[0], '>=') => $size >= $replace('>='),
            Str::startsWith($arguments[0], '>') => $size > $replace('>'),
            Str::startsWith($arguments[0], '=')=> $size === $replace('='),
            default => throw new \InvalidArgumentException("Invalid comparison operator"),
        };
        return $fn(File::size($value));
    }
}