<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ImageRatioRule;

class ImageRatioRuleTest extends TestCase
{
// テスト: 引数が空の場合は例外をスローするか
    #[Test]
    public function 引数が空の場合例外をスローする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Image ratio rule requires at least one argument");

        $instance = new ImageRatioRule();
        $parameters = $this->createParameter([]);
        $value = __DIR__ . '/dummy/Blank.jpg';
        $instance->passes('attribute', $value, $parameters, []);
    }

    // テスト: 無効な比率が引数として渡された場合は例外をスローするか
    #[Test]
    public function 無効な比率が渡された場合例外をスローする(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Image ratio rule requires a numeric ratio in the format of '16/9'");

        $instance = new ImageRatioRule();
        $parameters = $this->createParameter([]);
        $value = __DIR__ . '/dummy/Blank.jpg';
        $instance->passes('attribute', $value, $parameters, ['invalid ratio']);
    }

    // テスト: ImageRuleが失敗した場合、falseを返す
    #[Test]
    public function ImageRuleが失敗した場合falseを返す(): void
    {
        $instance = new ImageRatioRule();
        $parameters = $this->createParameter([]);
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $instance->passes('attribute', $value, $parameters, ['4/3']);

        $this->assertFalse($actual, "ImageRuleが失敗した場合はfalseを返す必要があります");
    }

    // テスト: 比率が一致する画像の場合はtrueを返す
    #[Test]
    public function 比率が一致する画像の場合trueを返す(): void
    {
        $instance = new ImageRatioRule();
        $parameters = $this->createParameter([]);
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $instance->passes('attribute', $value, $parameters, ['237/150']);

        $this->assertTrue($actual, "比率が一致する場合はtrueを返す必要があります");
    }

    // テスト: 比率が一致しない画像の場合はfalseを返す
    #[Test]
    public function 比率が一致しない画像の場合falseを返す(): void
    {

        $instance = new ImageRatioRule();
        $parameters = $this->createParameter([]);
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $instance->passes('attribute', $value, $parameters, ['4/3']);

        $this->assertFalse($actual, "比率が一致しない場合はfalseを返す必要があります");
    }
}