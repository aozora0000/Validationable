<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 使い捨てメールドメインを拒否するルール
 * - 文字列でない、またはメールフォーマットでない場合はfalse
 * - ドメインがブロックリストに含まれている場合はfalse
 */
class DisposableEmailRule implements RuleInterface
{
    /** @var string[] 簡易ブロックリスト */
    private array $blocklist = [
        'mailinator.com', '10minutemail.com', 'guerrillamail.com', 'yopmail.com', 'temp-mail.org',
        'trashmail.com', 'throwawaymail.com', 'dispostable.com', 'tempmail.com'
    ];

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $email = (string)$value;
        $at = strrpos($email, '@');
        if ($at === false || $at === strlen($email) - 1) {
            return false; // @が無いか末尾
        }

        $domain = strtolower(substr($email, $at + 1));
        // 引数で追加ドメインがあれば併合（テスト容易性のため）
        $block = array_unique(array_map('strtolower', array_merge($this->blocklist, $arguments)));

        return !in_array($domain, $block, true);
    }
}
