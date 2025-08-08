<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * ファイル内容からMIMEタイプを判定し、指定のMIMEに含まれるかを検証
 * - 引数: 許可するMIMEタイプの文字列リスト (例: ['image/png','image/jpeg'])
 */
class MimeTypeByContentRule implements RuleInterface
{
    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false; // パスは文字列必須
        }

        $path = (string)$value;
        if (!is_file($path)) {
            return false; // 実在ファイルのみ
        }

        if ($arguments === []) {
            return false; // 許可MIMEが未指定ならfalse
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($path) ?: '';
        return in_array($mime, $arguments, true);
    }
}
