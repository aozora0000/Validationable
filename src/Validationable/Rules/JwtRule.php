<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Arr;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class JwtRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value)) {
            return false;
        }

        // JWT形式: 3つのセクション（ヘッダー.ペイロード.署名）をドットで区切った形式
        $parts = array_map(fn($part): string => $part . '==', explode('.', $value));
        if (count($parts) !== 3) {
            return false;
        }

        $base64instance = new Base64Rule();
        return Arr::every($parts, fn(string $part): bool => $base64instance->passes($attribute, $part, $parameters));
    }
}