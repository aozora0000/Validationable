<?php

namespace Validationable\Helpers;

use Validationable\Contracts\RuleInterface;

class RuleArgumentParser
{
    public function __construct(protected array $rules, protected array $caches = [])
    {}

    /**
     * $valueは以下を想定
     * 1. RuleInterface
     * 2. 'rule'
     * 3. 'rule:arguments...'
     * 4. 'rule:"argument:args","argument"'
     * @param $value
     * @return array{0: RuleInterface, 1: string[], 2: bool}
     */
    public function parse($value): array
    {
        if($value instanceof RuleInterface) {
            return [$value, [], false];
        }

        if(!Str::of($value)) {
            throw new \InvalidArgumentException(sprintf("The rule [%s] is not a valid rule.", Str::stringify($value)));
        }

        $not = false;

        [$key, $arguments] = Str::contains($value, ":") ? explode(":", $value, 2) : [$value, ''];

        // !がルール前にある場合は、結果を反転させる
        if(Str::startsWith($key, '!')) {
            [$key, $not] = [substr($key, 1), true];
        }
        if(array_key_exists($key, $this->rules)) {
            $instance = $this->caches[$key] ?? new $this->rules[$key];
            return [$instance, $this->parseArguments($arguments), $not];
        }

        throw new \InvalidArgumentException(sprintf("The rule [%s] does not exist.", Str::stringify($value)));
    }


    public function parseArguments(string $argumentsString): array
    {
        if($argumentsString === '') {
            return [];
        }

        $arguments = [];
        $current = '';
        $inQuotes = false;
        $quoteChar = null;
        $i = 0;
        $length = strlen($argumentsString);

        while ($i < $length) {
            $char = $argumentsString[$i];

            if (!$inQuotes && ($char === '"' || $char === "'")) {
                // クォート開始
                $inQuotes = true;
                $quoteChar = $char;
                // クォート文字は$currentに追加しない
            } elseif ($inQuotes && $char === $quoteChar) {
                // 次の文字がエスケープされているかチェック
                $nextChar = $i + 1 < $length ? $argumentsString[$i + 1] : null;
                if ($nextChar === $quoteChar) {
                    // エスケープされたクォート
                    $current .= $char; // エスケープされた文字のみ追加
                    $i++; // 次の文字もスキップ
                } else {
                    // クォート終了
                    $inQuotes = false;
                    $quoteChar = null;
                    // 終了クォート文字は$currentに追加しない
                }
            } elseif (!$inQuotes && $char === ',') {
                // 区切り文字
                $arguments[] = trim($current);
                $current = '';
            } else {
                $current .= $char;
            }

            $i++;
        }

        // 最後の引数を追加
        if ($current !== '') {
            $arguments[] = trim($current);
        }

        return $arguments;
    }
}