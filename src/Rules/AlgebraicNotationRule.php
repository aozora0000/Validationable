<?php

namespace Validationable\Rules;

use InvalidArgumentException;
use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class AlgebraicNotationRule implements RuleInterface
{
    /**
     * 指定された代数表記（例: "2n+1"）の条件を満たすことを検証します。
     *
     * @param string $attribute
     * @param mixed $value
     * @param Parameters $parameters
     * @param array $arguments
     * @return bool
     */
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (empty($arguments[0])) {
            throw new InvalidArgumentException('The algebraic notation rule requires at least 1 argument.');
        }

        if (!is_numeric($value)) {
            return false;
        }
        $value = (float)$value;

        $notation = str_replace(' ', '', $arguments[0]);

        // Matches formats like: aN, aN+b, aN-b (case-insensitive N)
        if (!preg_match('/^(\d+)[nN](?:([+\-])(\d+))?$/', $notation, $matches)) {
            throw new InvalidArgumentException("Invalid format for algebraic notation rule. Expected format like '6N', '2n+1', or '3N-1'.");
        }

        $a = (int)$matches[1];
        if ($a === 0) {
            return false; // Division by zero is not allowed.
        }

        $operator = $matches[2] ?? null;
        $b = isset($matches[3]) ? (int)$matches[3] : 0;

        return match ($operator) {
            '+' => !($value < $b) && ($value - $b) % $a === 0,
            '-' => !($value < $a - $b) && ($value + $b) % $a === 0,
            default => $value % $a === 0
        };
    }
}
