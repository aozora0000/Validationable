<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class SqlInjectionRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value)) {
            return false;
        }

        // 危険なSQLキーワード/パターンのリスト
        $patterns = [
            '/\bUNION\b.*?\bSELECT\b/is',         // UNION SELECT
            '/\bOR\b\s+\d+\s*=\s*\d+/is',         // OR 1=1
            '/\bAND\b\s+\d+\s*=\s*\d+/is',        // AND 1=1
            '/--/',                               // SQLコメント
            '/\/\*.*?\*\//s',                     // C形式コメント
            '/;\s*\w+\s*[^_]\(/i',                // コマンド実行
            '/\bEXEC\b/i',                        // EXEC
            '/\bDROP\b.*?\bTABLE\b/is',           // DROP TABLE
            '/\bALTER\b.*?\bTABLE\b/is',          // ALTER TABLE
            '/\bDELETE\b.*?\bFROM\b/is',          // DELETE FROM
            '/\bINSERT\b.*?\bINTO\b/is',          // INSERT INTO
            '/\bSELECT\b.*?\bFROM\b/is',          // SELECT FROM
            '/\bUPDATE\b.*?\bSET\b/is',           // UPDATE SET
            '/\bCREATE\b.*?\bTABLE\b/is',         // CREATE TABLE
            '/\bTRUNCATE\b.*?\bTABLE\b/is'        // TRUNCATE TABLE
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return false;
            }
        }

        return true;
    }
}