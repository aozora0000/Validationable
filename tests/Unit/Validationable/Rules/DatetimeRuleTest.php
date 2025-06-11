<?php

namespace Tests\Unit\Validationable\Rules;

use DateTime;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\DatetimeRule;

class DatetimeRuleTest extends TestCase
{
    #[Test]
    public function パス値がDateTimeインスタンスの場合成功する(): void
    {
        // Arrange
        $instance = new DatetimeRule();
        $params = $this->createParameter([]);
        $value = new DateTime();

        // Act
        $result = $instance->passes('test', $value, $params);

        // Assert
        $this->assertTrue($result, 'DateTimeインスタンスの場合、検証に成功するはずです。');
    }

    #[Test]
    public function パス値が有効な日付文字列の場合成功する(): void
    {
        // Arrange
        $instance = new DatetimeRule();
        $params = $this->createParameter([]);
        $value = '2025-06-07 13:45:30';

        // Act
        $result = $instance->passes('test', $value, $params);

        // Assert
        $this->assertTrue($result, '有効な日付文字列の場合、検証に成功するはずです。');
    }

    #[Test]
    public function パス値が無効な日付文字列の場合失敗する(): void
    {
        // Arrange
        $instance = new DatetimeRule();
        $params = $this->createParameter([]);
        $value = '無効な文字列';

        // Act
        $result = $instance->passes('test', $value, $params);

        // Assert
        $this->assertFalse($result, '無効な日付文字列の場合、検証に失敗するはずです。');
    }

    #[Test]
    public function パス値がNULLの場合失敗する(): void
    {
        // Arrange
        $instance = new DatetimeRule();
        $params = $this->createParameter([]);
        $value = null;

        // Act
        $result = $instance->passes('test', $value, $params);

        // Assert
        $this->assertFalse($result, 'NULLの場合、検証に失敗するはずです。');
    }

    #[Test]
    public function パス値が空文字列の場合失敗する(): void
    {
        // Arrange
        $instance = new DatetimeRule();
        $params = $this->createParameter([]);
        $value = '';

        // Act
        $result = $instance->passes('test', $value, $params);

        // Assert
        $this->assertFalse($result, '空文字列の場合、検証に失敗するはずです。');
    }
}