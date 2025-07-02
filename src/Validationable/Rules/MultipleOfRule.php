<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class MultipleOfRule implements RuleInterface
{
    /**
     * 指定された数値の倍数であることを検証します。
     */
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if ($arguments === []) {
            throw new \InvalidArgumentException('The multiple of rule requires at least 1 argument.');
        }

        $multiple = $arguments[0];

        if (!is_numeric($value) || !is_numeric($multiple) || $multiple == 0) {
            return false;
        }

        return fmod((float)$value, (float)$multiple) === 0.0;
    }
}
