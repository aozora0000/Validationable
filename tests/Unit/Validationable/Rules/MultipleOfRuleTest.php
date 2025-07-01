<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\MultipleOfRule;

class MultipleOfRuleTest extends TestCase
{
    #[Test]
    public function 値が指定された数値の倍数である場合にtrueを返す(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 10]);
        $expected = true;

        // Act
        $actual = $instance->passes('field', 10, $parameters, [5]);

        // Assert
        $this->assertSame($expected, $actual, '10は5の倍数であるためtrueを期待します');
    }

    #[Test]
    public function 値が指定された数値の倍数でない場合にfalseを返す(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 10]);
        $expected = false;

        // Act
        $actual = $instance->passes('field', 10, $parameters, [3]);

        // Assert
        $this->assertSame($expected, $actual, '10は3の倍数ではないためfalseを期待���ます');
    }

    #[Test]
    public function 値が0の場合にtrueを返す(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 0]);
        $expected = true;

        // Act
        $actual = $instance->passes('field', 0, $parameters, [5]);

        // Assert
        $this->assertSame($expected, $actual, '0は任意の数の倍数であるためtrueを期待します');
    }

    #[Test]
    public function 倍数が0の場合にfalseを返す(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 10]);
        $expected = false;

        // Act
        $actual = $instance->passes('field', 10, $parameters, [0]);

        // Assert
        $this->assertSame($expected, $actual, '0による除算は許可されないためfalseを期待します');
    }

    #[Test]
    public function 値が数値でない場合にfalseを返す(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 'not_a_number']);
        $expected = false;

        // Act
        $actual = $instance->passes('field', 'not_a_number', $parameters, [5]);

        // Assert
        $this->assertSame($expected, $actual, '数値でない値は無効であるためfalseを期待します');
    }

    #[Test]
    public function 倍数が数値でない場合にfalseを返す(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 10]);
        $expected = false;

        // Act
        $actual = $instance->passes('field', 10, $parameters, ['not_a_number']);

        // Assert
        $this->assertSame($expected, $actual, '数値でない倍数は無効であるためfalseを期待します');
    }

    #[Test]
    public function 引数が空の場合に例外を投げる(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 10]);

        // Assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('The multiple of rule requires at least 1 argument.');

        // Act
        $instance->passes('field', 10, $parameters, []);
    }

    #[Test]
    public function 浮動小数点数の値と倍数で正しく動作する(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 7.5]);
        $expected = true;

        // Act
        $actual = $instance->passes('field', 7.5, $parameters, [2.5]);

        // Assert
        $this->assertSame($expected, $actual, '7.5は2.5の倍数であるためtrueを期待します');
    }

    #[Test]
    public function 浮動小数点数の値と整数で正しく動作する(): void
    {
        // Arrange
        $instance = new MultipleOfRule();
        $parameters = $this->createParameter(['field' => 10.0]);
        $expected = true;

        // Act
        $actual = $instance->passes('field', 10.0, $parameters, [5]);

        // Assert
        $this->assertSame($expected, $actual, '10.0は5の倍数であるためtrueを期待します');
    }
}
