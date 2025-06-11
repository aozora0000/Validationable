<?php

namespace Tests\Unit\Validationable\Rules;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\DateFormatRule;

class DateFormatRuleTest extends TestCase
{
    // テスト: 日付フォーマットが正しい場合
    #[Test]
    public function 日付フォーマットが正しい場合(): void
    {
        // Arrange
        $instance = new DateFormatRule();
        $attribute = 'date';
        $value = '2025-06-07';
        $parameters = $this->createParameter([]);  // パラメータモック
        $arguments = ['Y-m-d'];

        // Act
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // Assert
        $this->assertTrue($actual, '日付フォーマットが正しい場合、trueが期待されます。');
    }

    // テスト: 日付フォーマットが間違っている場合
    #[Test]
    public function 日付フォーマットが間違っている場合(): void
    {
        // Arrange
        $instance = new DateFormatRule();
        $attribute = 'date';
        $value = '07-06-2025';
        $parameters = $this->createParameter([]);  // パラメータモック
        $arguments = ['Y-m-d'];

        // Act
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // Assert
        $this->assertFalse($actual, '日付フォーマットが間違っている場合、falseが期待されます。');
    }

    // テスト: 日付値が空の場合
    #[Test]
    public function 日付値が空の場合(): void
    {
        // Arrange
        $instance = new DateFormatRule();
        $attribute = 'date';
        $value = '';
        $parameters = $this->createParameter([]);  // パラメータモック
        $arguments = ['Y-m-d'];

        // Act
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // Assert
        $this->assertFalse($actual, '日付値が空の場合、falseが期待されます。');
    }

    // テスト: 日付フォーマットが指定されていない場合
    #[Test]
    public function 日付フォーマットが指定されていない場合(): void
    {
        // Arrange
        $instance = new DateFormatRule();
        $attribute = 'date';
        $value = '2025-06-07';
        $parameters = $this->createParameter([]);  // パラメータモック
        $arguments = [];

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The date format is required.');

        // Act
        $instance->passes($attribute, $value, $parameters, $arguments);
    }

    // テスト: 日付が正しくない型の場合
    #[Test]
    public function 日付が正しくない型の場合(): void
    {
        // Arrange
        $instance = new DateFormatRule();
        $attribute = 'date';
        $value = 12345; // 数値を渡す
        $parameters = $this->createParameter([]);  // パラメータモック
        $arguments = ['Y-m-d'];

        // Act
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // Assert
        $this->assertFalse($actual, '日付が正しくない型の場合、falseが期待されます。');
    }
}