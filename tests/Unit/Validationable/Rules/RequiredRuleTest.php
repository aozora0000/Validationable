<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\RequiredRule;

class RequiredRuleTest extends TestCase
{
    #[Test]
    public function 値が存在する時にTrueが返る(): void
    {
        $instance = new RequiredRule();
        $actual = $instance->passes('test', 'value', $this->createParameter(['test' => 'value']));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 値がnullの時にFalseが返る(): void
    {
        $instance = new RequiredRule();
        $actual = $instance->passes('test', null, $this->createParameter(['test' => null]));
        $this->assertFalse($actual);
    }

    #[Test]
    public function 値が空文字の時にFalseが返る(): void
    {
        $instance = new RequiredRule();
        $actual = $instance->passes('test', '', $this->createParameter(['test' => '']));
        $this->assertFalse($actual);
    }

    #[Test]
    public function 値が空配列の時にFalseが返る(): void
    {
        $instance = new RequiredRule();
        $actual = $instance->passes('test', [], $this->createParameter(['test' => []]));
        $this->assertFalse($actual);
    }

    #[Test]
    public function キーが存在しない時にFalseが返る(): void
    {
        $instance = new RequiredRule();
        $actual = $instance->passes('nonexistent', null, $this->createParameter(['test' => 'value']));
        $this->assertFalse($actual);
    }

    #[Test]
    public function 数値のゼロの時にTrueが返る(): void
    {
        $instance = new RequiredRule();
        $actual = $instance->passes('test', 0, $this->createParameter(['test' => 0]));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 文字列のゼロの時にTrueが返る(): void
    {
        $instance = new RequiredRule();
        $actual = $instance->passes('test', '0', $this->createParameter(['test' => '0']));
        $this->assertTrue($actual);
    }

    #[Test]
    public function falseの時にTrueが返る(): void
    {
        $instance = new RequiredRule();
        $actual = $instance->passes('test', false, $this->createParameter(['test' => false]));
        $this->assertTrue($actual);
    }
}