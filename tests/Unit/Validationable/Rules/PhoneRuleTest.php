<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Parameters;
use Validationable\Rules\PhoneRule;

class PhoneRuleTest extends TestCase
{
    #[Test]
    public function 電話番号が有効である場合はtrueを返す(): void
    {
        // テスト対象のクラス
        $instance = new PhoneRule();

        // 入力値と期待値を設定
        $attribute = 'phone';
        $value = '+811234567890';
        $parameters = $this->createParameter([]);
        $arguments = ['JP'];

        // 実際の結果
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertTrue($actual, '電話番号が有効である場合にtrueを返すべきです。');
    }

    #[Test]
    public function 電話番号が無効である場合はfalseを返す(): void
    {
        // テスト対象のクラス
        $instance = new PhoneRule();

        // 入力値と期待値を設定
        $attribute = 'phone';
        $value = '123ABC';
        $parameters = $this->createParameter([]);
        $arguments = ['US'];

        // 実際の結果
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertFalse($actual, '電話番号が無効である場合にfalseを返すべきです。');
    }

    #[Test]
    public function 空文字列の場合はfalseを返す(): void
    {
        // テスト対象のクラス
        $instance = new PhoneRule();

        // 入力値と期待値を設定
        $attribute = 'phone';
        $value = '';
        $parameters = $this->createParameter([]);
        $arguments = ['JP'];

        // 実際の結果
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertFalse($actual, '空文字列の場合にfalseを返すべきです。');
    }

    #[Test]
    public function nullの場合はfalseを返す(): void
    {
        // テスト対象のクラス
        $instance = new PhoneRule();

        // 入力値と期待値を設定
        $attribute = 'phone';
        $value = null;
        $parameters = $this->createParameter([]);
        $arguments = ['JP'];

        // 実際の結果
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertFalse($actual, 'nullの場合にfalseを返すべきです。');
    }

    #[Test]
    public function 国コードが省略された場合はデフォルト言語を使用する(): void
    {
        // テスト対象のクラス
        $instance = new PhoneRule();

        // 入力値と期待値を設定
        $attribute = 'phone';
        $value = '+811234567890';
        $parameters = $this->createParameter([]);
        $arguments = [];

        // 実際の結果
        $actual = $instance->passes($attribute, $value, $parameters, $arguments);

        // アサーション
        $this->assertTrue($actual, '国コードが省略された場合、デフォルト言語で有効な電話番号をtrueとするべきです。');
    }
}