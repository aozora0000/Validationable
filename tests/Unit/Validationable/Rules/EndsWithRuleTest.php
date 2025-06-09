<?php

namespace Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\EndsWithRule;

class EndsWithRuleTest extends TestCase
{

    #[Test]
    public function 引数が文字列・数字以外を含む場合に例外をスローすることを確認する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The endsWith rule requires at least 1 argument.');

        $value = 'example';
        $attribute = 'testAttribute';
        $parameters = $this->createParameter([]);
        $instance = new EndsWithRule();
        $instance->passes($attribute, $value, $parameters, ['prefix', []]);
    }

    #[Test]
    public function 値が指定されたプレフィックスで始まる場合にtrueを返す(): void
    {
        $value = 'StringExample';
        $attribute = 'testAttribute';
        $parameters = $this->createParameter([]);
        $arguments = ['Example', 'test'];
        $instance = new EndsWithRule();
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, '値がプレフィックスで始まる場合にtrueを返すべきです。');
    }

    #[Test]
    public function 値が指定されたプレフィックスで始まらない場合にfalseを返す(): void
    {
        $value = 'exampleString';
        $attribute = 'testAttribute';
        $parameters = $this->createParameter([]);
        $arguments = ['postfix', 'test'];
        $instance = new EndsWithRule();
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '値がプレフィックスで始まらない場合にfalseを返すべきです。');
    }

    #[Test]
    public function 引数が空の場合に例外をスローすることを確認する(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The endsWith rule requires at least 1 argument.');

        $value = 'example';
        $attribute = 'testAttribute';
        $parameters = $this->createParameter([]);
        $instance = new EndsWithRule();
        $instance->passes($attribute, $value, $parameters, []);
    }
}