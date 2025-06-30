<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class HashRule implements RuleInterface
{
    private array $patterns = [
        'md5' => '/^[a-f0-9]{32}$/i',
        'sha1' => '/^[a-f0-9]{40}$/i',
        'sha256' => '/^[a-f0-9]{64}$/i',
        'sha512' => '/^[a-f0-9]{128}$/i',
        'bcrypt' => '/^\$2[ayb]\$[0-9]{2}\$[A-Za-z0-9\.\/]{53}$/'
    ];

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        $pattern = $arguments[0] ?? 'md5';
        if(!array_key_exists($pattern, $this->patterns)) {
            throw new \InvalidArgumentException('An undefined hashing algorithm was detected.');
        }
        return Str::match($value, $this->patterns[$pattern]);
    }
}