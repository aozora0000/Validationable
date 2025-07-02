<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\JwtRule;

class JwtRuleTest extends TestCase
{
    #[Test]
    public function 有効なJwtを渡すとTrueが返る(): void
    {
        $instance = new JwtRule();
        $parameters = $this->createParameter([]);
        $value = implode('.', array_map(fn($v): string => rtrim(base64_encode($v), '=='), ['a', 'b', 'c']));

        $actual = $instance->passes('token', $value, $parameters);

        $this->assertTrue($actual, '有効なJWTを渡した場合にtrueが返るべきです。');
    }

    #[Test]
    public function 無効なJwtを渡すとFalseが返る(): void
    {
        $instance = new JwtRule();
        $parameters = $this->createParameter([]);
        $value = "無効なJWT";

        $actual = $instance->passes('token', $value, $parameters);

        $this->assertFalse($actual, '無効なJWTを渡した場合にfalseが返るべきです。');
    }

    #[Test]
    public function Jwtに含まれるセクションが3つ未満の場合にFalseが返る(): void
    {
        $instance = new JwtRule();
        $parameters = $this->createParameter([]);
        $value = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ";

        $actual = $instance->passes('token', $value, $parameters);

        $this->assertFalse($actual, 'JWTに含まれるセクションが3つ未満の場合にfalseが返るべきです。');
    }

    #[Test]
    public function Jwtに含まれるセクションのいずれかがBase64形式でない場合にFalseが返る(): void
    {
        $instance = new JwtRule();
        $parameters = $this->createParameter([]);
        $value = "invalid.header.payload.signature";

        $actual = $instance->passes('token', $value, $parameters);

        $this->assertFalse($actual, 'セクションのいずれかがBase64形式でない場合にfalseが返るべきです。');
    }

    #[Test]
    public function 空の値を渡すとFalseが返る(): void
    {
        $instance = new JwtRule();
        $parameters = $this->createParameter([]);
        $value = "";

        $actual = $instance->passes('token', $value, $parameters);

        $this->assertFalse($actual, '空の値を渡した場合にfalseが返るべきです。');
    }

    #[Test]
    public function 非文字列の値を渡すとFalseが返る(): void
    {
        $instance = new JwtRule();
        $parameters = $this->createParameter([]);
        $value = 12345;

        $actual = $instance->passes('token', $value, $parameters);

        $this->assertFalse($actual, '非文字列の値を渡した場合にfalseが返るべきです。');
    }
}