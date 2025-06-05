<?php

namespace Tests\Unit\Validationable\Rules;

use Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Validationable\Parameters;
use Validationable\Rules\BetweenRule;

class BetweenRuleTest extends TestCase
{
    #[Test]
    public function 値が整数でない場合はfalseを返す(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 'not_integer']);
        
        $actual = $instance->passes('test', 'not_integer', $parameters, [1, 10]);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 引数が空の場合は例外を投げる(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 5]);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The between rule requires at least 1 argument.');
        
        $instance->passes('test', 5, $parameters, []);
    }

    #[Test]
    public function 引数がすべて整数でない場合は例外を投げる(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 5]);
        
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The between rule requires at least 1 argument.');
        
        $instance->passes('test', 5, $parameters, ['not_integer']);
    }

    #[Test]
    public function 最小値と最大値の両方が指定されている場合_値が範囲内であればtrueを返す(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 5]);
        
        $actual = $instance->passes('test', 5, $parameters, [1, 10]);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 最小値と最大値の両方が指定されている場合_値が範囲外であればfalseを返す(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 15]);
        
        $actual = $instance->passes('test', 15, $parameters, [1, 10]);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 最小値と最大値の両方が指定されている場合_値が最小値と同じであればtrueを返す(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 1]);
        
        $actual = $instance->passes('test', 1, $parameters, [1, 10]);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 最小値と最大値の両方が指定されている場合_値が最大値と同じであればtrueを返す(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 10]);
        
        $actual = $instance->passes('test', 10, $parameters, [1, 10]);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数の順序が逆でも正しく動作する(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 5]);
        
        $actual = $instance->passes('test', 5, $parameters, [10, 1]);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数が1つの場合_値が引数以上であればtrueを返す(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 5]);
        
        $actual = $instance->passes('test', 5, $parameters, [3]);
        
        $this->assertTrue($actual);
    }

    #[Test]
    public function 引数が1つの場合_値が引数未満であればfalseを返す(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 2]);
        
        $actual = $instance->passes('test', 2, $parameters, [3]);
        
        $this->assertFalse($actual);
    }

    #[Test]
    public function 文字列の整数値でも正しく動作する(): void
    {
        $instance = new BetweenRule();
        $parameters = $this->createParameter(['test' => 5]);
        
        $actual = $instance->passes('test', '5', $parameters, [1, 10]);
        
        $this->assertTrue($actual);
    }
}