<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

class Base64Rule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        // Base64 文字セットの検証 (RFC 4648)
        if (!Str::of($value) || Str::empty($value) || !preg_match('/^[A-Za-z0-9+\/]*={0,2}$/', $value)) {
            return false;
        }

        // デコードしてエンコードして元に戻るか確認
        $decoded = base64_decode($value, true);
        return $decoded !== false && base64_encode($decoded) === $value;

    }
}