<?php

namespace Validationable\Validators;

use Egulias\EmailValidator\EmailLexer;
use Egulias\EmailValidator\Result\InvalidEmail;
use Egulias\EmailValidator\Validation\EmailValidation;
use Egulias\EmailValidator\Warning\Warning;

class FilterEmailValidation implements EmailValidation
{
    /**
     * Returns true if the given email is valid.
     *
     * @param string $email
     * @param EmailLexer $emailLexer
     * @return bool
     */
    public function isValid(string $email, EmailLexer $emailLexer): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Returns the validation error.
     *
     * @return InvalidEmail|null
     */
    public function getError(): ?InvalidEmail
    {
        return null;
    }

    /**
     * Returns the validation warnings.
     *
     * @return Warning[]
     */
    public function getWarnings(): array
    {
        return [];
    }
}