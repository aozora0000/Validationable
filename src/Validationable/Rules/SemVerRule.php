<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;
use z4kn4fein\SemVer\Constraints\Constraint;
use z4kn4fein\SemVer\Version;

class SemVerRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!is_string($value)) {
            return false;
        }

        try {
            $target = Version::parse($value);
            if(!isset($arguments[0])) {
                return true;
            }

            $compare = Constraint::parse($arguments[0]);
            return $target->isSatisfying($compare);

        } catch (\Throwable) {
            return false;
        }
    }
}
