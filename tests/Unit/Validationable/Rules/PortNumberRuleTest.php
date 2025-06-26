<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\PortNumberRule;

class PortNumberRuleTest extends TestCase
{
    #[Test]
    public function 有効なポート番号の場合はtrueを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertTrue($rule->passes('port', 80, $this->createParameter([])));
    }

    #[Test]
    public function ポート番号が1の場合はtrueを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertTrue($rule->passes('port', 1, $this->createParameter([])));
    }

    #[Test]
    public function ポート番号が65535の場合はtrueを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertTrue($rule->passes('port', 65535, $this->createParameter([])));
    }

    #[Test]
    public function ポート番号が0の場合はfalseを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertFalse($rule->passes('port', 0, $this->createParameter([])));
    }

    #[Test]
    public function ポート番号が65536の場合はfalseを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertFalse($rule->passes('port', 65536, $this->createParameter([])));
    }

    #[Test]
    public function 文字列形式の有効なポート番号の場合はtrueを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertTrue($rule->passes('port', '8080', $this->createParameter([])));
    }

    #[Test]
    public function 小数の場合はfalseを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertFalse($rule->passes('port', 80.80, $this->createParameter([])));
    }

    #[Test]
    public function 文字列の場合はfalseを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertFalse($rule->passes('port', 'not-a-port', $this->createParameter([])));
    }

    #[Test]
    public function nullの場合はfalseを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertFalse($rule->passes('port', null, $this->createParameter([])));
    }

    #[Test]
    public function 空文字列の場合はfalseを返す(): void
    {
        $rule = new PortNumberRule();
        $this->assertFalse($rule->passes('port', '', $this->createParameter([])));
    }
}
