<?php

namespace Validationable\Rules;

use DOMDocument;
use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class HtmlRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || Str::empty($value)) {
            return false;
        }

        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        $result = @$doc->loadHTML($value, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);
        libxml_clear_errors();

        return $result !== false;
    }
}