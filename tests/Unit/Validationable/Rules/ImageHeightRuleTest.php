<?php

namespace Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\ImageHeightRule;

class ImageHeightRuleTest extends TestCase
{
    #[Test]
    public function 指定した画像の縦幅が引数と同じかを確認する(): void
    {
        $rule = new ImageHeightRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['150']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定した画像の縦幅が演算子つき引数と同じかを確認する(): void
    {
        $rule = new ImageHeightRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['=150']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定した画像の縦幅が引数の通りに小さいかを確認する(): void
    {
        $rule = new ImageHeightRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['<=150']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定した画像の縦幅が引数の通りに未満かを確認する(): void
    {
        $rule = new ImageHeightRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['<150']);
        $this->assertFalse($actual);
    }

    #[Test]
    public function 指定した画像の縦幅が引数の通りに大きいかを確認する(): void
    {
        $rule = new ImageHeightRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['>=150']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定した画像の縦幅が引数の通りに超過かを確認する(): void
    {
        $rule = new ImageHeightRule();
        $params = $this->createParameter([]);
        // width: 237, height: 150
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['>150']);
        $this->assertFalse($actual);
    }
}