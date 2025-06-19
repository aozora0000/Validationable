<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\File;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class FileMtime implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if($arguments === []) {
            throw new \InvalidArgumentException("FileMtime rule requires at least one argument");
        }

        if (in_array(preg_match('/\d+$/u', $arguments[0]), [0, false], true)) {
            throw new \InvalidArgumentException("FileMtime rule requires a valid size");
        }

        if(!(new FileRule())->passes($attribute, $value, $parameters, $arguments)) {
            return false;
        }

        $replace = fn(string $arg): int => (int)str_replace($arg, '', $arguments[0]);
        $fn = fn(int $mtime): bool => match(true) {
            (bool)preg_match('/^\d+$/', $arguments[0]) => $mtime === (int)$arguments[0],
            Str::startsWith($arguments[0], '==')=> $mtime === $replace('=='),
            Str::startsWith($arguments[0], '<=') => $mtime <= $replace('<='),
            Str::startsWith($arguments[0], '<') => $mtime < $replace('<'),
            Str::startsWith($arguments[0], '>=') => $mtime >= $replace('>='),
            Str::startsWith($arguments[0], '>') => $mtime > $replace('>'),
            Str::startsWith($arguments[0], '=')=> $mtime === $replace('='),
            default => throw new \InvalidArgumentException("Invalid comparison operator"),
        };
        return $fn(File::mtime($value));
    }
}