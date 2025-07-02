<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class InCidrRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if ($arguments === []) {
            throw new \InvalidArgumentException("InCidr rule requires at least one argument");
        }

        if(!Str::of($value) || !str_contains($arguments[0], '/')) {
            return false;
        }

        [$subnet, $bits] = explode('/', $arguments[0]);
        if (!filter_var($subnet, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ||
            !is_numeric($bits) ||
            $bits < 0 ||
            $bits > 32) {
            return false;
        }

        if (!filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return false;
        }

        $ip = ip2long($value);
        $subnet = ip2long($subnet);
        $mask = -1 << (32 - $bits);
        $subnet &= $mask;

        return ($ip & $mask) === $subnet;
    }
}