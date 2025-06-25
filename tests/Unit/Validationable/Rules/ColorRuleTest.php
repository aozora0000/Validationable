<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ColorRule;

class ColorRuleTest extends TestCase
{
    #[Test]
    public function 正しいHEXカラーコードを検証する()
    {
        $instance = new ColorRule();
        $parameters = $this->createParameter([]);
        $value = '#FFAABB';
        $attribute = 'color';
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, "HEXカラーコード{$value}の検証に失敗しました。");
    }

    #[Test]
    public function 不正なHEXカラーコードを検証する()
    {
        $instance = new ColorRule();
        $parameters = $this->createParameter([]);
        $value = '#XYZ123';
        $attribute = 'color';
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "不正なHEXカラーコード{$value}が許可されました。");
    }

    #[Test]
    public function 正しいRGB形式を検証する()
    {
        $instance = new ColorRule();
        $parameters = $this->createParameter([]);
        $value = 'rgb(255, 128, 64)';
        $attribute = 'color';
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, "RGB形式{$value}の検証に失敗しました。");
    }

    #[Test]
    public function 不正なRGB形式を検証する()
    {
        $instance = new ColorRule();
        $parameters = $this->createParameter([]);
        $value = 'rgb(256, 128, -1)';
        $attribute = 'color';
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "不正なRGB形式{$value}が許可されました。");
    }

    #[Test]
    public function 正しいHSL形式を検証する()
    {
        $instance = new ColorRule();
        $parameters = $this->createParameter([]);
        $value = 'hsl(120, 100%, 50%)';
        $attribute = 'color';
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, "HSL形式{$value}の検証に失敗しました。");
    }

    #[Test]
    public function 不正なHSL形式を検証する()
    {
        $instance = new ColorRule();
        $parameters = $this->createParameter([]);
        $value = 'hsl(120, 100, 50%)';
        $attribute = 'color';
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "不正なHSL形式{$value}が許可されました。");
    }

    #[Test]
    public function 不正な文字列を検証する()
    {
        $instance = new ColorRule();
        $parameters = $this->createParameter([]);
        $value = 'invalid-color';
        $attribute = 'color';
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "不正な文字列{$value}が許可されました。");
    }

    #[Test]
    public function 空文字列を検証する()
    {
        $instance = new ColorRule();
        $parameters = $this->createParameter([]);
        $value = '';
        $attribute = 'color';
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "空文字列が許可されました。");
    }
}