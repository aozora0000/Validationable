<?php

namespace Validationable\Rules;

use libphonenumber\PhoneNumberUtil;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class PhoneRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(!Str::of($value)) {
            return false;
        }
        try {
            $lang = $arguments[0] ?? 'ja';

            return PhoneNumberUtil::getInstance()->isPossibleNumber($value, $lang);
        } catch (\Throwable $e) {
            return false;
        }
    }
}