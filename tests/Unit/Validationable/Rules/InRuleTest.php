<?php

namespace Tests\Unit\Validationable\Rules;

use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\TestCase;
use Validationable\Rules\InRule;

class InRuleTest extends TestCase
{
    #[Test]
    public function 引数が空の場合は例外をスローする(): void
    {
        // テストインスタンスを作成
        $instance = new InRule();

        // パラメータモックを作成
        $parameters = $this->createParameter(['test_attribute' => 'apple']);

        // 例外が発生することを期待
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("In rule requires arguments.");

        // テスト実行
        $instance->passes('test_attribute', $parameters, []);
    }

    #[Test]
    public function 値が引数の配列に含まれている場合はtrueを返す(): void
    {
        // テストインスタンスを作成
        $instance = new InRule();

        // パラメータモックを作成
        $parameters = $this->createParameter(['test_attribute' => 'apple']);

        // テスト実行
        $actual = $instance->passes('test_attribute', $parameters, ['apple', 'banana', 'orange']);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 値が引数の配列に含まれていない場合はfalseを返す(): void
    {
        // テストインスタンスを作成
        $instance = new InRule();

        // パラメータモックを作成
        $parameters = $this->createParameter(['test_attribute' => 'grape']);

        // テスト実行
        $actual = $instance->passes('test_attribute', $parameters, ['apple', 'banana', 'orange']);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 属性がパラメータに存在しない場合はfalseを返す(): void
    {
        // テストインスタンスを作成
        $instance = new InRule();

        // パラメータモックを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('non_existent_attribute', $parameters, ['apple', 'banana']);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 値が空文字列で引数の配列に空文字列が含まれている場合はtrueを返す(): void
    {
        // テストインスタンスを作成
        $instance = new InRule();

        // パラメータモックを作成
        $parameters = $this->createParameter(['test_attribute' => '']);

        // テスト実行
        $actual = $instance->passes('test_attribute', $parameters, ['', 'apple', 'banana']);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 値が空文字列で引数の配列に空文字列が含まれていない場合はfalseを返す(): void
    {
        // テストインスタンスを作成
        $instance = new InRule();

        // パラメータモックを作成
        $parameters = $this->createParameter(['test_attribute' => '']);

        // テスト実行
        $actual = $instance->passes('test_attribute', $parameters, ['apple', 'banana']);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 数値の値が引数の配列に含まれている場合はtrueを返す(): void
    {
        // テストインスタンスを作成
        $instance = new InRule();

        // パラメータモックを作成
        $parameters = $this->createParameter(['test_attribute' => '123']);

        // テスト実行
        $actual = $instance->passes('test_attribute', $parameters, ['123', '456', '789']);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 型の厳密比較で異なる型の値の場合はTrueを返す(): void
    {
        // テストインスタンスを作成
        $instance = new InRule();

        // パラメータモックを作成
        $parameters = $this->createParameter(['test_attribute' => '123']);

        // テスト実行（文字列の'123'と数値の123は厳密比較でfalse）
        $actual = $instance->passes('test_attribute', $parameters, [123, 456, 789]);

        // アサーション
        $this->assertTrue($actual);
    }
}