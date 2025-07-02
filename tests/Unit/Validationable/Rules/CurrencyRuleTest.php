<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\CurrencyRule;

class CurrencyRuleTest extends TestCase
{
    /**
     * CurrencyRuleのpassesメソッドのテスト：有効な通貨コードを渡した場合
     */
    #[Test]
    public function 有効な通貨コードを渡した場合(): void
    {
        $instance = new CurrencyRule();
        $attribute = 'currency';
        $value = 'USD'; // 想定される有効な通貨コード
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertTrue($actual, '有効な通貨コードが正しく検証されませんでした: ' . $value);
    }

    /**
     * CurrencyRuleのpassesメソッドのテスト：無効な通貨コードを渡した場合
     */
    #[Test]
    public function 無効な通貨コードを渡した場合(): void
    {
        $instance = new CurrencyRule();
        $attribute = 'currency';
        $value = 'INVALID'; // 想定される無効な通貨コード
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '無効な通貨コードが正しく検証されませんでした: ' . $value);
    }

    /**
     * CurrencyRuleのpassesメソッドのテスト：値がnullの場合
     */
    #[Test]
    public function 値がnullの場合(): void
    {
        $instance = new CurrencyRule();
        $attribute = 'currency';
        $value = null; // nullが渡された場合
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "null 値が正しく検証されませんでした");
    }

    /**
     * CurrencyRuleのpassesメソッドのテスト：空文字列を渡した場合
     */
    #[Test]
    public function 空文字列を渡した場合(): void
    {
        $instance = new CurrencyRule();
        $attribute = 'currency';
        $value = ''; // 空文字列が渡された場合
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, "空文字列が正しく検証されませんでした");
    }

    /**
     * CurrencyRuleのpassesメソッドのテスト：数値を渡した場合
     */
    #[Test]
    public function 数値を渡した場合(): void
    {
        $instance = new CurrencyRule();
        $attribute = 'currency';
        $value = 123; // 数値が渡された場合
        $parameters = $this->createParameter([]);
        $arguments = [];

        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        $this->assertFalse($actual, '数値が正しく検証されませんでした: ' . $value);
    }
}