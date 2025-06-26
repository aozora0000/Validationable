<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\AsciiRule;

class AsciiRuleTest extends TestCase
{
    #[Test]
    public function ascii文字列の場合はtrueを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertTrue($rule->passes('ascii', 'hello world', $this->createParameter([])));
    }

    #[Test]
    public function 数字を含むascii文字列の場合はtrueを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertTrue($rule->passes('ascii', '12345', $this->createParameter([])));
    }

    #[Test]
    public function 記号を含むascii文字列の場合はtrueを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertTrue($rule->passes('ascii', '!@#$%^&*()', $this->createParameter([])));
    }

    #[Test]
    public function 制御文字を含むascii文字列の場合はtrueを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertTrue($rule->passes('ascii', "\n\r\t", $this->createParameter([])));
    }

    #[Test]
    public function 日本語が含まれる場合はfalseを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertFalse($rule->passes('ascii', 'こんにちは', $this->createParameter([])));
    }

    #[Test]
    public function 絵文字が含まれる場合はfalseを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertFalse($rule->passes('ascii', '😂', $this->createParameter([])));
    }

    #[Test]
    public function nullの場合はfalseを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertFalse($rule->passes('ascii', null, $this->createParameter([])));
    }

    #[Test]
    public function 空文字列の場合はtrueを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertTrue($rule->passes('ascii', '', $this->createParameter([])));
    }

    #[Test]
    public function 数値の場合はfalseを返す(): void
    {
        $rule = new AsciiRule();
        $this->assertFalse($rule->passes('ascii', 123, $this->createParameter([])));
    }
}