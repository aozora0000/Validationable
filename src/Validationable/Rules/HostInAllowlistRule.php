<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 入力のホスト名が許可リストに含まれるかを検証
 * - 入力はホスト名、またはURL（parse_urlでhost抽出）を許容
 * - 引数: 許可するホスト名の配列
 */
class HostInAllowlistRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $s = (string)$value;
        $host = parse_url($s, PHP_URL_HOST);
        if ($host === 0 || ($host === '' || $host === '0') || $host === [] || $host === false || $host === null) {
            // URLでなければ、値をそのままホストとみなす
            $host = $s;
        }

        $host = strtolower($host);
        $allow = array_map('strtolower', $arguments);
        return in_array($host, $allow, true);
    }
}
