<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\HexRule;

class HexRuleTest extends TestCase
{
    /**
     * HexRule::passes メソッドの有効な16進数値に対するテスト
     */
    #[Test]
    public function 有効な16進数値をテストする(): void
    {
        $instance = new HexRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', '1a2b3c', $parameters);

        $this->assertTrue($actual, '有効な16進数値が正しく検証されませんでした。');
    }

    /**
     * HexRule::passes メソッドの無効な16進数値に対するテスト（英字・記号含む）
     */
    #[Test]
    public function 無効な16進数値をテストする(): void
    {
        $instance = new HexRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', '1g2@3h', $parameters);

        $this->assertFalse($actual, '無効な16進数値が正しく検証されませんでした。');
    }

    /**
     * HexRule::passes メソッドの無効なデータ型（null）に対するテスト
     */
    #[Test]
    public function 無効なデータ型_nullをテストする(): void
    {
        $instance = new HexRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', null, $parameters);

        $this->assertFalse($actual, 'null値が不適切に16進数として検証されました。');
    }

    /**
     * HexRule::passes メソッドの無効なデータ型（配列）に対するテスト
     */
    #[Test]
    public function 無効なデータ型_配列をテストする(): void
    {
        $instance = new HexRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', ['1a2b3c'], $parameters);

        $this->assertFalse($actual, '配列が不適切に16進数として検証されました。');
    }

    /**
     * HexRule::passes メソッドの空文字列に対するテスト
     */
    #[Test]
    public function 空文字列をテストする(): void
    {
        $instance = new HexRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('test_attribute', '', $parameters);

        $this->assertFalse($actual, '空文字列が不適切に16進数として検証されました。');
    }
}