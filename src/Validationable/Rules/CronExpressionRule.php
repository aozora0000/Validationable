<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 簡易Cron式(5フィールド)のバリデーション
 * - フィールド: 分 時 日 月 曜日
 * - 各フィールドは *, 数字, 範囲(a-b), リスト(a,b), ステップ(スター/数値, a-b/数値) を許容
 * - 厳密な数値範囲までは検証しない（最小実装）
 */
class CronExpressionRule implements RuleInterface
{
    private function isFieldValid(string $field): bool
    {
        $part = '(?:\*|\?|\d{1,2}|\d{1,2}-\d{1,2})(?:/\d{1,2})?';
        $list = $part . '(?:,' . $part . ')*';
        return (bool)preg_match('#^' . $list . '$#', $field);
    }

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $expr = trim((string)$value);
        $fields = preg_split('/\s+/', $expr);
        if (count($fields) !== 5) {
            return false; // 5フィールド限定
        }

        foreach ($fields as $field) {
            if (!$this->isFieldValid($field)) {
                return false;
            }
        }

        return true;
    }
}
