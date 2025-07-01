<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\File;
use Validationable\Parameters;

class MimesRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if($arguments === []) {
            throw new \InvalidArgumentException("Mimes rule requires at least one argument");
        }

        $arguments = array_map('strtolower', $arguments);
        return in_array(File::mimes($value), $arguments, true);
    }
}