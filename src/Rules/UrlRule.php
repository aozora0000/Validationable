<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class UrlRule implements RuleInterface
{
    public static array $protocols = [
        'http',
        'https',
        'ftp',
        'sftp',
        'git',
    ];
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $protocols = array_merge(self::$protocols, $arguments);
        $callbacks = [
            fn () => Arr::some($protocols, fn($protocol) => Str::startsWith($value, $protocol)),
        ];
        if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $value)) {
            $callbacks[] = fn() => preg_match('/(?:(?:25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(?:25[0-5]|2[0-4]\d|[01]?\d\d?)/', $value);
        }
        return filter_var($value, FILTER_VALIDATE_URL) && Arr::every($callbacks, fn(callable $callback) => $callback());
    }
}