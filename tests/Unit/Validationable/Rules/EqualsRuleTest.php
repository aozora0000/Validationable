<?php

namespace Tests\Unit\Validationable\Rules;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\EqualsRule;

class EqualsRuleTest extends TestCase
{
    #[Test]
    public function 正常系_引数と値が一致する場合(): void
    {
        $instance = new EqualsRule();
        $parameters = $this->createParameter([]);

        $attribute = 'test';
        $value = 'example';
        $arguments = ['example'];

        // 実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // 検証
        $this->assertTrue($actual, '値と引数が一致する場合はtrueを返すべきです。');
    }

    #[Test]
    public function 正常系_引数と値が一致しない場合(): void
    {
        $instance = new EqualsRule();
        $parameters = $this->createParameter([]);

        $attribute = 'test';
        $value = 'example';
        $arguments = ['different'];

        // 実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // 検証
        $this->assertFalse($actual, '値と引数が一致しない場合はfalseを返すべきです。');
    }

    #[Test]
    public function 正常系_型が異なるが値が一致する場合(): void
    {
        $instance = new EqualsRule();
        $parameters = $this->createParameter([]);

        $attribute = 'test';
        $value = 12345;
        $arguments = ['12345'];

        // 実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // 検証
        $this->assertTrue($actual, '型が異なっても値が一致する場合はtrueを返すべきです。');
    }

    #[Test]
    public function 正常系_引数がParameterに存在するキーでかつ値が一致する場合(): void
    {
        $instance = new EqualsRule();
        $parameters = $this->createParameter(['argument' => 'example']);

        $attribute = 'test';
        $value = 'example';
        $arguments = ['argument'];

        // 実行
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // 検証
        $this->assertTrue($actual, '値と引数が一致する場合はtrueを返すべきです。');
    }

    #[Test]
    public function 異常系_引数が空の場合(): void
    {
        $instance = new EqualsRule();
        $parameters = $this->createParameter([]);

        $attribute = 'test';
        $value = 'example';
        $arguments = [];

        // 実行と検証: 引数が空の場合は例外をスローすべき
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('EqualsRule rule requires at least one argument');

        $instance->passes($attribute, $value, $parameters, $arguments);
    }
}