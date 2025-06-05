<?php

namespace Tests\Unit\Validationable\Rules;

use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use stdClass;
use Tests\Unit\TestCase;
use Validationable\Rules\ArrayRule;

/**
 * ArrayRuleクラスのユニットテスト
 */
class ArrayRuleTest extends TestCase
{
    #[Test]
    public function 配列の値の場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ArrayRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', [1, 2, 3], $parameters);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 空配列の場合はtrueを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ArrayRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', [], $parameters);

        // アサーション
        $this->assertTrue($actual);
    }

    #[Test]
    public function 文字列の値の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ArrayRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', 'string', $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function 数値の値の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ArrayRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', 123, $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function nullの値の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ArrayRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', null, $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function booleanの値の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ArrayRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', true, $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function オブジェクトの値の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ArrayRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', new stdClass(), $parameters);

        // アサーション
        $this->assertFalse($actual);
    }

    #[Test]
    public function Collection値の場合はfalseを返す(): void
    {
        // テスト対象のインスタンスを作成
        $instance = new ArrayRule();

        // テストパラメータを作成
        $parameters = $this->createParameter([]);

        // テスト実行
        $actual = $instance->passes('field', new Collection(), $parameters);

        // アサーション
        $this->assertTrue($actual);
    }
}