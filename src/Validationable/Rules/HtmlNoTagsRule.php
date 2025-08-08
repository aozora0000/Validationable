<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * HTMLタグが含まれていないことを検証
 */
class HtmlNoTagsRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value)) {
            return false;
        }

        $s = (string)$value;
        // strip_tagsで除去した結果が同一であればタグ無し
        return $s === strip_tags($s);
    }
}
