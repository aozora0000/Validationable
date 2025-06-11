<?php

namespace Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\DateRule;

class DateRuleTest extends TestCase
{
    /**
     * 日付形式の有効な値がtrueを返すかどうかをテスト
     */
    #[Test]
    public function 日付形式の文字列の場合_trueを返す(): void
    {
        $instance = new DateRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', '2025-06-07', $parameters);

        $this->assertTrue($actual, '日付形式の文字列が正しく評価されませんでした。');
    }

    /**
     * 日付形式でない文字列がfalseを返すかどうかをテスト
     */
    #[Test]
    public function 日付形式でない文字列の場合_falseを返す(): void
    {
        $instance = new DateRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', 'invalid-date', $parameters);

        $this->assertFalse($actual, '日付形式でない文字列が適切に評価されませんでした。');
    }

    /**
     * 空の文字列がfalseを返すかどうかをテスト
     */
    #[Test]
    public function 空の文字列の場合_falseを返す(): void
    {
        $instance = new DateRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', '', $parameters);

        $this->assertFalse($actual, '空の文字列が適切に評価されませんでした。');
    }

    /**
     * nullがfalseを返すかどうかをテスト
     */
    #[Test]
    public function nullの場合_falseを返す(): void
    {
        $instance = new DateRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', null, $parameters);

        $this->assertFalse($actual, 'nullが適切に評価されませんでした。');
    }

    /**
     * 数字のみの文字列がfalseを返すかどうかをテスト
     */
    #[Test]
    public function 数字のみの文字列の場合_falseを返す(): void
    {
        $instance = new DateRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', 2, $parameters);

        $this->assertFalse($actual, '数字のみの文字列が適切に評価されませんでした。');
    }

    /**
     * 無効な日付形式の文字列がfalseを返すかどうかをテスト
     */
    #[Test]
    public function 無効な日付形式の場合_falseを返す(): void
    {
        $instance = new DateRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', '2025-99-99', $parameters);

        $this->assertFalse($actual, '無効な日付形式の文字列が適切に評価されませんでした。');
    }

    /**
     * 日付形式の時間付き文字列がtrueを返すかどうかをテスト
     */
    #[Test]
    public function 日付と時間付き文字列の場合_trueを返す(): void
    {
        $instance = new DateRule();
        $parameters = $this->createParameter([]);

        $actual = $instance->passes('attribute', '2025-06-07 12:30:45', $parameters);

        $this->assertTrue($actual, '日付と時間付き文字列が正しく評価されませんでした。');
    }
}