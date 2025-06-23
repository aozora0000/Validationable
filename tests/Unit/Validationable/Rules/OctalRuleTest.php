<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\OctalRule;

class OctalRuleTest extends TestCase
{
    #[Test]
    public function 正当な8進数の場合にtrueを返す(): void
    {
        // テストデータ
        $value = '755';
        $parameters = $this->createParameter([]);

        // 実行結果
        $instance = new OctalRule();
        $actual = $instance->passes('attribute', $value, $parameters);

        // アサーション
        $this->assertTrue($actual, '正当な8進数がtrueを返すことを期待しました。');
    }

    #[Test]
    public function 数字以外を含む場合にfalseを返す(): void
    {
        // テストデータ
        $value = '75a';
        $parameters = $this->createParameter([]);

        // 実行結果
        $instance = new OctalRule();
        $actual = $instance->passes('attribute', $value, $parameters);

        // アサーション
        $this->assertFalse($actual, '数字以外を含む場合にfalseを返すことを期待しました。');
    }

    #[Test]
    public function 無効な8進数を含む場合にfalseを返す(): void
    {
        // テストデータ
        $value = '789';
        $parameters = $this->createParameter([]);

        // 実行結果
        $instance = new OctalRule();
        $actual = $instance->passes('attribute', $value, $parameters);

        // アサーション
        $this->assertFalse($actual, '無効な8進数がfalseを返すことを期待しました。');
    }

    #[Test]
    public function 空文字の場合にfalseを返す(): void
    {
        // テストデータ
        $value = '';
        $parameters = $this->createParameter([]);

        // 実行結果
        $instance = new OctalRule();
        $actual = $instance->passes('attribute', $value, $parameters);

        // アサーション
        $this->assertFalse($actual, '空文字の場合にfalseを返すことを期待しました。');
    }

    #[Test]
    public function nullの場合にfalseを返す(): void
    {
        // テストデータ
        $value = null;
        $parameters = $this->createParameter([]);

        // 実行結果
        $instance = new OctalRule();
        $actual = $instance->passes('attribute', $value, $parameters);

        // アサーション
        $this->assertFalse($actual, 'nullの場合にfalseを返すことを期待しました。');
    }

    #[Test]
    public function 小数点を含む場合にfalseを返す(): void
    {
        // テストデータ
        $value = '75.5';
        $parameters = $this->createParameter([]);

        // 実行結果
        $instance = new OctalRule();
        $actual = $instance->passes('attribute', $value, $parameters);

        // アサーション
        $this->assertFalse($actual, '小数点を含む場合にfalseを返すことを期待しました。');
    }

    #[Test]
    public function 負の数の場合にfalseを返す(): void
    {
        // テストデータ
        $value = '-755';
        $parameters = $this->createParameter([]);

        // 実行結果
        $instance = new OctalRule();
        $actual = $instance->passes('attribute', $value, $parameters);

        // アサーション
        $this->assertFalse($actual, '負の数の場合にfalseを返すことを期待しました。');
    }
}