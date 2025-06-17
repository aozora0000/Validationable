<?php

namespace Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ImageWidthRule;

class ImageWidthRuleTest extends TestCase
{
    #[Test]
    public function 指定した画像の横幅が引数と同じかを確認する(): void
    {
        $rule = new ImageWidthRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['237']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定した画像の横幅が演算子つき引数と同じかを確認する(): void
    {
        $rule = new ImageWidthRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['=237']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定した画像の横幅が引数の通りに小さいかを確認する(): void
    {
        $rule = new ImageWidthRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['<=237']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定した画像の横幅が引数の通りに未満かを確認する(): void
    {
        $rule = new ImageWidthRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['<237']);
        $this->assertFalse($actual);
    }

    #[Test]
    public function 指定した画像の横幅が引数の通りに大きいかを確認する(): void
    {
        $rule = new ImageWidthRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['>=237']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定した画像の横幅が引数の通りに超過かを確認する(): void
    {
        $rule = new ImageWidthRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['>237']);
        $this->assertFalse($actual);
    }
}