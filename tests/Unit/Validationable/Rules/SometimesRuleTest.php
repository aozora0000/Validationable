<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\SometimesRule;

class SometimesRuleTest extends TestCase
{
    #[Test]
    public function 属性が存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', 'value', $this->createParameter(['test' => 'value']));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 属性が存在しない時にFalseが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('nonexistent', null, $this->createParameter(['test' => 'value']));
        $this->assertFalse($actual);
    }

    #[Test]
    public function 属性の値がnullでも存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', null, $this->createParameter(['test' => null]));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 属性の値が空文字でも存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', '', $this->createParameter(['test' => '']));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 属性の値が空配列でも存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', [], $this->createParameter(['test' => []]));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 属性の値がfalseでも存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', false, $this->createParameter(['test' => false]));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 空のパラメータで属性が存在しない時にFalseが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', null, $this->createParameter([]));
        $this->assertFalse($actual);
    }

    #[Test]
    public function ネストした配列で属性が存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $values = ['user' => ['name' => 'John']];
        $actual = $instance->passes('user.name', 'John', $this->createParameter($values));
        $this->assertTrue($actual);
    }

    #[Test]
    public function ネストした配列で属性が存在しない時にFalseが返る(): void
    {
        $instance = new SometimesRule();
        $values = ['user' => ['name' => 'John']];
        $actual = $instance->passes('user.email', null, $this->createParameter($values));
        $this->assertFalse($actual);
    }
}