<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 安全なファイル名かどうかを検証
 * - 英数字、ドット、アンダースコア、ハイフンのみ
 * - パス区切りや制御文字を含まない
 */
class SafeFilenameRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $name = (string)$value;
        if (str_contains($name, '/') || str_contains($name, '\\')) {
            return false; // ディレクトリ区切りは不可
        }

        // 制御文字チェック
        if (preg_match('/[\x00-\x1F\x7F]/', $name)) {
            return false;
        }

        return (bool)preg_match('/^[A-Za-z0-9._-]+$/', $name);
    }
}
