<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\Base64Rule;

class Base64RuleTest extends TestCase
{
    #[Test]
    public function 有効なBase64を検証する()
    {
        $parameters = $this->createParameter([]);
        $value = 'SGVsbG8gd29ybGQ='; // "Hello world" in Base64
        $instance = new Base64Rule();
        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertTrue($actual, '有効なBase64文字列検証が失敗しました。');
    }

    #[Test]
    public function 無効なBase64文字列を検証する()
    {
        $parameters = $this->createParameter([]);
        $value = 'InvalidBase64!!'; // 非Base64文字列
        $instance = new Base64Rule();
        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertFalse($actual, '無効なBase64文字列が通過しました。');
    }

    #[Test]
    public function 空文字列を検証する()
    {
        $parameters = $this->createParameter([]);
        $value = '';
        $instance = new Base64Rule();
        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertFalse($actual, '空文字列が通過しました。');
    }

    #[Test]
    public function 不完全なBase64パディングを検証する()
    {
        $parameters = $this->createParameter([]);
        $value = 'SGVsbG8gd29ybGQ'; // パディングが不足している
        $instance = new Base64Rule();
        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertFalse($actual, '不完全なBase64パディングが通過しました。');
    }

    #[Test]
    public function 有効なBase64パディングを検証する()
    {
        $parameters = $this->createParameter([]);
        $value = 'SGVsbG8g'; // "Hello" encoded, valid padding
        $instance = new Base64Rule();
        $actual = $instance->passes('attribute', $value, $parameters);

        $this->assertTrue($actual, '有効なBase64パディング検証が失敗しました。');
    }

    #[Test]
    public function Base64デコードが失敗する文字列を検証する()
    {
        $parameters = $this->createParameter([]);
        $value = 'SGVsbG8gd29ybGQ='; // これは有効だが、エラーをシミュレーションするとします
        $instance = new Base64Rule();
        $actual = $instance->passes('attribute', "\x80Invalid", $parameters);

        $this->assertFalse($actual, 'Base64デコードが失敗する文字列が通過しました。');
    }
}