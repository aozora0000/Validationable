<?php

namespace Validationable\Rules;

use SplFileInfo;
use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class FileRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        return match(true) {
            is_string($value) => is_file($value) && is_readable($value),
            is_resource($value) => true,
            is_a($value, SplFileInfo::class) => $value->isFile(),
            default => false,
        };
    }
}