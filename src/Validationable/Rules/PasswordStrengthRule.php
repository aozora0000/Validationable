<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class PasswordStrengthRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $arguments[0] ??= 'strong';
        if(!Str::of($value)) {
            return false;
        }
        if (!$length = \strlen($value)) {
            return $arguments[0] === 'very_weak';
        }
        $password = count_chars($value, 1);
        $chars = \count($password);

        $control = $digit = $upper = $lower = $symbol = $other = 0;
        foreach ($password as $chr => $count) {
            match (true) {
                $chr < 32 || 127 === $chr => $control = 33,
                48 <= $chr && $chr <= 57 => $digit = 10,
                65 <= $chr && $chr <= 90 => $upper = 26,
                97 <= $chr && $chr <= 122 => $lower = 26,
                128 <= $chr => $other = 128,
                default => $symbol = 33,
            };
        }

        $pool = $lower + $upper + $digit + $symbol + $control + $other;
        $entropy = $chars * log($pool, 2) + ($length - $chars) * log($chars, 2);

        $strength = match (true) {
            $entropy >= 100 => 'strong',
            $entropy >= 80 => 'medium',
            $entropy >= 60 => 'weak',
            default => 'very_weak',
        };
        return match ($arguments[0]) {
            'strong' => $strength === 'strong',
            'medium' => in_array($strength, ['strong', 'medium']),
            'weak' => in_array($strength, ['strong', 'medium', 'weak']),
            'very_weak' => true,
        };
    }
}