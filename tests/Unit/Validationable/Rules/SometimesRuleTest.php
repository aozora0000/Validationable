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
        $actual = $instance->passes('test', $this->createParameter(['test' => 'value']));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 属性が存在しない時にFalseが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('nonexistent', $this->createParameter(['test' => 'value']));
        $this->assertFalse($actual);
    }

    #[Test]
    public function 属性の値がnullでも存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', $this->createParameter(['test' => null]));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 属性の値が空文字でも存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', $this->createParameter(['test' => '']));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 属性の値が空配列でも存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', $this->createParameter(['test' => []]));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 属性の値がfalseでも存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', $this->createParameter(['test' => false]));
        $this->assertTrue($actual);
    }

    #[Test]
    public function 空のパラメータで属性が存在しない時にFalseが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('test', $this->createParameter([]));
        $this->assertFalse($actual);
    }

    #[Test]
    public function ネストした配列で属性が存在する時にTrueが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('user.name', $this->createParameter(['user' => ['name' => 'John']]));
        $this->assertTrue($actual);
    }

    #[Test]
    public function ネストした配列で属性が存在しない時にFalseが返る(): void
    {
        $instance = new SometimesRule();
        $actual = $instance->passes('user.email', $this->createParameter(['user' => ['name' => 'John']]));
        $this->assertFalse($actual);
    }
}