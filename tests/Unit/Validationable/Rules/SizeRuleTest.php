<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\RulesSizeRule;
use Validationable\Rules\SizeRule;

class SizeRuleTest extends TestCase
{
    #[Test]
    public function 指定したファイルのサイズが引数と同じかを確認する(): void
    {
        $rule = new SizeRule();
        $params = $this->createParameter([]);
        // 2275bytes
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['2275']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定したファイルのサイズが演算子つき引数と同じかを確認する(): void
    {
        $rule = new SizeRule();
        $params = $this->createParameter([]);
        // 2275bytes
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['=2275']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定したファイルのサイズが引数の通りに小さいかを確認する(): void
    {
        $rule = new SizeRule();
        $params = $this->createParameter([]);
        // 2275bytes
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['<=2275']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定したファイルのサイズが引数の通りに未満かを確認する(): void
    {
        $rule = new SizeRule();
        $params = $this->createParameter([]);
        // 2275bytes
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['<2275']);
        $this->assertFalse($actual);
    }

    #[Test]
    public function 指定したファイルのサイズが引数の通りに大きいかを確認する(): void
    {
        $rule = new SizeRule();
        $params = $this->createParameter([]);
        // 2275bytes
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['>=2275']);
        $this->assertTrue($actual);
    }

    #[Test]
    public function 指定したファイルのサイズが引数の通りに超過かを確認する(): void
    {
        $rule = new SizeRule();
        $params = $this->createParameter([]);
        // 2275bytes
        $value = __DIR__ . '/dummy/Blank.jpg';
        $actual = $rule->passes('test', $value, $params, ['>2275']);
        $this->assertFalse($actual);
    }
}