<?php

namespace Validationable\Rules;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MessageIDValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\Str;
use Validationable\Parameters;
use Validationable\Validators\FilterEmailValidation;

class EmailRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value)) {
            return false;
        }
        $validator = new EmailValidator();

        $validations = !empty($arguments) && Arr::every($arguments, fn($arg) => Str::of($arg)) ?
            Arr::only(static::getValidators(), $arguments) : [];
        $validations[] = new FilterEmailValidation();
        return $validator->isValid($value, new MultipleValidationWithAnd($validations));
    }

    /**
     * @var array<string, RFCValidation>
     */
    public static function getValidators(): array
    {
        return [
            'rfc' => new RFCValidation(),
            'dns' => new DNSCheckValidation(),
            'message_id' => new MessageIDValidation(),
        ];
    }
}