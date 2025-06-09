<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Parameters;

class ActiveUrlRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if(!Arr::everyPasses([new UrlRule], $attribute, $value, $parameters, $arguments)) {
            return false;
        }
        $host = parse_url($value, PHP_URL_HOST);
        if(!$host) {
            return false;
        }
        return match(true) {
            filter_var($host, FILTER_VALIDATE_IP) !== false => gethostbyaddr($host) !== false,
            default => gethostbyname($host) !== $host,
        };
    }
}